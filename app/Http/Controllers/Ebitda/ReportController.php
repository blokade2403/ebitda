<?php

namespace App\Http\Controllers\Ebitda;

use App\Exports\ExpenseCategoryExport;
use App\Exports\FinanceHierarchyExport;
use App\Exports\FinanceReportExport;
use App\Exports\FinanceUnitExport;
use App\Exports\ReportExport;
use App\Exports\RevenueUnitExport;
use App\Http\Controllers\Controller;
use App\Models\Ebitda\Expense;
use App\Models\MasterBackend\SettingUser\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function revenuePerUnit(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $data = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->join('units as u', 'u.id', '=', 'pv.unit_id')
            ->select(
                'u.nama_unit',
                DB::raw('SUM(pv.jumlah_pasien * ms.tarif) as revenue')
            )
            ->whereYear('pv.tanggal', $tahun)
            ->groupBy('u.nama_unit')
            ->get();

        return Excel::download(new RevenueUnitExport($data), 'revenue_per_unit.xlsx');
    }

    public function expensePerCategory(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $data = DB::table('expenses as e')
            ->join('expense_categories as ec', 'ec.id', '=', 'e.expense_category_id')
            ->join('units as u', 'u.id', '=', 'e.unit_id')
            ->select(
                'u.nama_unit',
                'ec.nama',
                'ec.kelompok',
                DB::raw('SUM(e.jumlah) as total_expense')
            )
            ->whereYear('e.tanggal', $tahun)
            ->groupBy('u.nama_unit', 'ec.nama', 'ec.kelompok')
            ->get();

        return Excel::download(new ExpenseCategoryExport($data), 'expense_per_category.xlsx');
    }

    public function financeHierarchy(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ags',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        /* ================= REVENUE BULANAN ================= */

        $revenues = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->selectRaw('
                pv.unit_id,
                MONTH(pv.tanggal) as bulan,
                SUM(pv.jumlah_pasien * ms.tarif) as revenue
            ')
            ->whereYear('pv.tanggal', $tahun)
            ->groupBy('pv.unit_id', 'bulan')
            ->get();

        /* ================= EXPENSE BULANAN ================= */

        $expenses = DB::table('expenses')
            ->selectRaw('
                unit_id,
                MONTH(tanggal) as bulan,
                SUM(jumlah) as expense
            ')
            ->whereYear('tanggal', $tahun)
            ->groupBy('unit_id', 'bulan')
            ->get();

        /* ================= MAP DATA ================= */

        $revenueMap = [];

        foreach ($revenues as $row) {
            $revenueMap[$row->unit_id][$row->bulan] = $row->revenue;
        }

        $expenseMap = [];

        foreach ($expenses as $row) {
            $expenseMap[$row->unit_id][$row->bulan] = $row->expense;
        }

        /* ================= AMBIL POSITION ================= */

        $positions = Position::with('unit')->get();

        /* ================= BUILD TREE ================= */

        $tree = $this->buildTree($positions);

        $data = [];

        foreach ($tree as $node) {

            $this->flattenTree($node, $data, $revenueMap, $expenseMap, $namaBulan);
        }

        return Excel::download(
            new FinanceHierarchyExport($data),
            'finance_hierarchy_monthly.xlsx'
        );
    }


    private function getFinanceData()
    {
        $tanggal = date('Y-m-d');

        /* ================= TARGET REVENUE ================= */

        $targetRevenue = DB::table('financial_targets')
            ->where('category_type', 'revenue')
            ->sum('amount');

        $targetDaily = $targetRevenue / 365;

        /* ================= TARGET EXPENSE ================= */

        $targetCost = DB::table('financial_targets as ft')
            ->join('expense_categories as ec', 'ec.id', '=', 'ft.category_id')
            ->selectRaw('
            SUM(CASE WHEN ec.kelompok="variable" THEN amount ELSE 0 END) as variable,
            SUM(CASE WHEN ec.kelompok="fixed" THEN amount ELSE 0 END) as fixed,
            SUM(CASE WHEN ec.kelompok="ioc" THEN amount ELSE 0 END) as ioc
        ')
            ->where('ft.category_type', 'expense')
            ->first();

        $targetTotalCost =
            ($targetCost->variable ?? 0) +
            ($targetCost->fixed ?? 0) +
            ($targetCost->ioc ?? 0);

        $targetEbitda = $targetRevenue - $targetTotalCost;

        $targetMargin = $targetRevenue > 0
            ? ($targetEbitda / $targetRevenue) * 100
            : 0;

        /* ================= PLAN REVENUE ================= */

        $planRevenue = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->selectRaw('SUM(pv.jumlah_pasien * ms.tarif) as total')
            ->whereDate('pv.tanggal', $tanggal)
            ->value('total');

        /* ================= PLAN EXPENSE ================= */

        $planCost = DB::table('expenses as e')
            ->join('expense_categories as ec', 'ec.id', '=', 'e.expense_category_id')
            ->selectRaw('
            SUM(CASE WHEN ec.kelompok="variable" THEN jumlah ELSE 0 END) as variable,
            SUM(CASE WHEN ec.kelompok="fixed" THEN jumlah ELSE 0 END) as fixed,
            SUM(CASE WHEN ec.kelompok="ioc" THEN jumlah ELSE 0 END) as ioc
        ')
            ->whereDate('e.tanggal', $tanggal)
            ->first();

        $planTotalCost =
            ($planCost->variable ?? 0) +
            ($planCost->fixed ?? 0) +
            ($planCost->ioc ?? 0);

        $planEbitda = ($planRevenue ?? 0) - $planTotalCost;

        $planMargin = ($planRevenue ?? 0) > 0
            ? ($planEbitda / $planRevenue) * 100
            : 0;

        /* ================= ACTUAL ================= */

        $actualRevenue = $planRevenue; // biasanya actual sama dengan transaksi visit

        $actualVariable = $planCost->variable ?? 0;
        $actualFixed = $planCost->fixed ?? 0;
        $actualIoc = $planCost->ioc ?? 0;

        $actualTotalCost = $actualVariable + $actualFixed + $actualIoc;

        $actualEbitda = $actualRevenue - $actualTotalCost;

        $actualMargin = $actualRevenue > 0
            ? ($actualEbitda / $actualRevenue) * 100
            : 0;

        return [

            'target' => [
                'revenue' => $targetRevenue,
                'daily' => $targetDaily,
                'variable' => $targetCost->variable ?? 0,
                'fixed' => $targetCost->fixed ?? 0,
                'ioc' => $targetCost->ioc ?? 0,
                'total_cost' => $targetTotalCost,
                'ebitda' => $targetEbitda,
                'margin' => $targetMargin
            ],

            'plan' => [
                'revenue' => $planRevenue ?? 0,
                'variable' => $planCost->variable ?? 0,
                'fixed' => $planCost->fixed ?? 0,
                'ioc' => $planCost->ioc ?? 0,
                'total_cost' => $planTotalCost,
                'ebitda' => $planEbitda,
                'margin' => $planMargin
            ],

            'actual' => [
                'revenue' => $actualRevenue,
                'variable' => $actualVariable,
                'fixed' => $actualFixed,
                'ioc' => $actualIoc,
                'total_cost' => $actualTotalCost,
                'ebitda' => $actualEbitda,
                'margin' => $actualMargin
            ]

        ];
    }

    public function exportExcel()
    {

        $data = $this->getFinanceData(); // fungsi yang sama dengan dashboard

        return Excel::download(
            new ReportExport($data),
            'reportexport.xlsx'
        );
    }

    /* ================= BUILD POSITION TREE ================= */

    private function buildTree($positions, $parentId = null)
    {
        $branch = [];

        foreach ($positions as $pos) {

            if ($pos->parent_id == $parentId) {

                $children = $this->buildTree($positions, $pos->id);

                $pos->children = $children;

                $branch[] = $pos;
            }
        }

        return $branch;
    }

    /* ================= HITUNG FINANCE RECURSIVE ================= */

    private function calculateFinance($node, $revenueMap, $expenseMap, $level = 0)
    {
        $rev = array_fill(1, 12, 0);
        $exp = array_fill(1, 12, 0);

        $unitId = $node->unit_id ?? null;

        if ($unitId) {

            for ($m = 1; $m <= 12; $m++) {

                $rev[$m] += $revenueMap[$unitId][$m] ?? 0;
                $exp[$m] += $expenseMap[$unitId][$m] ?? 0;
            }
        }

        foreach ($node->children as $child) {

            $childData = $this->calculateFinance($child, $revenueMap, $expenseMap, $level + 1);

            for ($m = 1; $m <= 12; $m++) {

                $rev[$m] += $childData['rev'][$m];
                $exp[$m] += $childData['exp'][$m];
            }
        }

        return [
            'rev' => $rev,
            'exp' => $exp
        ];
    }

    private function flattenTree($node, &$rows, $revenueMap, $expenseMap, $namaBulan, $level = 0)
    {
        $finance = $this->calculateFinance($node, $revenueMap, $expenseMap);

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $rev = $finance['rev'][$bulan];
            $exp = $finance['exp'][$bulan];

            $rows[] = [
                'Position' => str_repeat('   ', $level) . $node->nama_jabatan,
                'Unit' => $node->unit->nama_unit ?? '-',
                'Bulan' => $namaBulan[$bulan],
                'Revenue' => $rev,
                'Expense' => $exp,
                'EBITDA' => $rev - $exp
            ];
        }

        foreach ($node->children as $child) {

            $this->flattenTree($child, $rows, $revenueMap, $expenseMap, $namaBulan, $level + 1);
        }
    }

    public function financePerUnit(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        /* ================= REVENUE ================= */

        $revenues = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->selectRaw('pv.unit_id, SUM(pv.jumlah_pasien * ms.tarif) as revenue')
            ->whereYear('pv.tanggal', $tahun)
            ->groupBy('pv.unit_id')
            ->pluck('revenue', 'pv.unit_id');

        /* ================= EXPENSE ================= */

        $expenses = DB::table('expenses as e')
            ->join('expense_categories as ec', 'ec.id', '=', 'e.expense_category_id')
            ->selectRaw('e.unit_id,
            SUM(CASE WHEN ec.kelompok="DOC Variable" THEN e.jumlah ELSE 0 END) as doc_variable,
            SUM(CASE WHEN ec.kelompok="DOC Fixed" THEN e.jumlah ELSE 0 END) as doc_fixed,
            SUM(CASE WHEN ec.kelompok="IOC" THEN e.jumlah ELSE 0 END) as ioc
        ')
            ->whereYear('e.tanggal', $tahun)
            ->groupBy('e.unit_id')
            ->get()
            ->keyBy('unit_id');

        /* ================= UNITS ================= */

        $units = DB::table('units')->get();

        $data = [];

        foreach ($units as $unit) {

            $rev = $revenues[$unit->id] ?? 0;

            $docVariable = $expenses[$unit->id]->doc_variable ?? 0;
            $docFixed    = $expenses[$unit->id]->doc_fixed ?? 0;
            $ioc         = $expenses[$unit->id]->ioc ?? 0;

            $totalExpense = $docVariable + $docFixed + $ioc;

            $data[] = [
                'unit' => $unit->nama_unit,
                'revenue' => $rev,
                'doc_variable' => $docVariable,
                'doc_fixed' => $docFixed,
                'ioc' => $ioc,
                'total_expense' => $totalExpense,
                'ebitda' => $rev - $totalExpense,
            ];
        }

        return Excel::download(new FinanceUnitExport($data), 'finance_per_unit.xlsx');
    }

    public function downloadFinanceReport(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $summary = DB::table('units as u')
            ->leftJoin('patient_visits as pv', 'pv.unit_id', '=', 'u.id')
            ->leftJoin('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->selectRaw('
            u.nama_unit,
            SUM(pv.jumlah_pasien * ms.tarif) as revenue
        ')
            ->groupBy('u.nama_unit')
            ->get();

        $monthly = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->selectRaw('
            pv.unit_id,
            MONTH(pv.tanggal) bulan,
            SUM(pv.jumlah_pasien * ms.tarif) as revenue
        ')
            ->whereYear('pv.tanggal', $tahun)
            ->groupBy('pv.unit_id', 'bulan')
            ->get();

        $expenseCategory = DB::table('expenses as e')
            ->join('expense_categories as ec', 'ec.id', '=', 'e.expense_category_id')
            ->join('units as u', 'u.id', '=', 'e.unit_id')
            ->select(
                'u.nama_unit',
                'ec.nama',
                'ec.kelompok',
                DB::raw('SUM(e.jumlah) as total')
            )
            ->groupBy('u.nama_unit', 'ec.nama', 'ec.kelompok')
            ->get();

        $revenueService = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->join('units as u', 'u.id', '=', 'pv.unit_id')
            ->select(
                'u.nama_unit',
                'ms.nama_layanan',
                DB::raw('SUM(pv.jumlah_pasien * ms.tarif) as revenue')
            )
            ->groupBy('u.nama_unit', 'ms.nama_layanan')
            ->get();

        return Excel::download(
            new FinanceReportExport($summary, $monthly, $expenseCategory, $revenueService),
            'finance_report.xlsx'
        );
    }

    private function getAllChildren($positions, $parentId)
    {
        $children = $positions->where('parent_id', $parentId);

        $ids = collect();

        foreach ($children as $child) {
            $ids->push($child->id);
            $ids = $ids->merge($this->getAllChildren($positions, $child->id));
        }

        return $ids;
    }
}
