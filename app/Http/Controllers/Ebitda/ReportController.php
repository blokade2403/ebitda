<?php

namespace App\Http\Controllers\Ebitda;

use App\Exports\ExpenseCategoryExport;
use App\Exports\FinanceHierarchyExport;
use App\Exports\FinanceReportExport;
use App\Exports\FinanceUnitExport;
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

        $positions = Position::with('unit')->get();

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
            ->selectRaw('pv.unit_id, MONTH(pv.tanggal) as bulan,
            SUM(pv.jumlah_pasien * ms.tarif) as revenue')
            ->whereYear('pv.tanggal', $tahun)
            ->groupBy('pv.unit_id', 'bulan')
            ->get()
            ->groupBy('unit_id');

        /* ================= EXPENSE BULANAN ================= */

        $expenses = DB::table('expenses')
            ->selectRaw('unit_id, MONTH(tanggal) as bulan,
            SUM(jumlah) as expense')
            ->whereYear('tanggal', $tahun)
            ->groupBy('unit_id', 'bulan')
            ->get()
            ->groupBy('unit_id');

        $data = [];

        foreach ($positions as $pos) {

            /* ambil seluruh child position */
            $childIds = $this->getAllChildren($positions, $pos->id);

            $allIds = $childIds->push($pos->id);

            /* ambil unit dari semua hirarki */
            $unitIds = $positions
                ->whereIn('id', $allIds)
                ->pluck('unit_id')
                ->filter()
                ->unique();

            for ($bulan = 1; $bulan <= 12; $bulan++) {

                $rev = 0;
                $exp = 0;

                foreach ($unitIds as $unitId) {

                    $rev += optional(
                        $revenues->get($unitId)?->where('bulan', $bulan)->first()
                    )->revenue ?? 0;

                    $exp += optional(
                        $expenses->get($unitId)?->where('bulan', $bulan)->first()
                    )->expense ?? 0;
                }

                $data[] = [
                    'position' => $pos->nama_jabatan,
                    'unit' => $pos->unit->nama_unit ?? '-',
                    'bulan' => $namaBulan[$bulan],
                    'revenue' => $rev,
                    'expense' => $exp,
                    'ebitda' => $rev - $exp,
                ];
            }
        }

        return Excel::download(
            new FinanceHierarchyExport($data),
            'finance_hierarchy_monthly.xlsx'
        );
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
