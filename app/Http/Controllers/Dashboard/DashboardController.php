<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ebitda\DailyFinance;
use App\Models\Ebitda\Expense;
use App\Models\Ebitda\ExpenseCategory;
use App\Models\Ebitda\FinancialTargets;
use App\Models\Ebitda\PatientVisit;
use App\Models\Ebitda\PatientVisitTarget;
use App\Models\Ebitda\Revenue;
use App\Models\Ebitda\TargetExpense;
use App\Models\MasterBackend\SettingUser\Position;
use App\Models\MasterBackend\SettingUser\Unit;
use App\Models\MasterBackend\UserProfil\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate = request('start_date')
            ? Carbon::parse(request('start_date'))
            : Carbon::today();

        $endDate = request('end_date')
            ? Carbon::parse(request('end_date'))
            : Carbon::today();

        $today = Carbon::today();
        $tahun = date('Y');
        $user = auth()->user();

        /* ===================== HIRARKI USER ===================== */

        $positionIds = $this->getChildPositions($user->position_id);

        $unitIds = Position::whereIn('id', $positionIds)
            ->pluck('unit_id')
            ->filter()
            ->unique();

        if ($unitIds->isEmpty()) {
            $unitIds = Unit::pluck('id');
        }

        $units = Unit::whereIn('id', $unitIds)->get();

        /* ===================== TARGET TAHUNAN ===================== */

        // Ambil semua target untuk unit dan tahun
        $targets = FinancialTargets::with(['unit', 'revenueCategory', 'expenseCategory'])
            // ->whereIn('unit_id', $unitIds)
            ->where('tahun', $tahun)
            ->get();

        $docVariableIds = ExpenseCategory::where('kelompok', 'DOC Variable')->pluck('id')->toArray();
        $docFixedIds    = ExpenseCategory::where('kelompok', 'DOC Fixed')->pluck('id')->toArray();
        $iocIds         = ExpenseCategory::where('kelompok', 'IOC')->pluck('id')->toArray();

        // Ambil nilai target berdasarkan kategori
        $targetRevenue = $targets->where('category_type', 'revenue')->sum('amount');
        $targetDocVariable = $targets->where('category_type', 'expense')
            ->whereIn('category_id', $docVariableIds)
            ->sum('amount');

        $targetDocFixed = $targets->where('category_type', 'expense')
            ->whereIn('category_id', $docFixedIds)
            ->sum('amount');

        $targetIoc = $targets->where('category_type', 'expense')
            ->whereIn('category_id', $iocIds)
            ->sum('amount');

        // Revenue plan
        $planRevenue = PatientVisitTarget::whereIn('unit_id', $unitIds)
            ->with('service')
            ->whereYear('tanggal', $tahun)
            ->get()
            ->sum(fn($row) => $row->target_pasien * $row->service->tarif);

        // Expense plan
        $planExpenses = TargetExpense::whereIn('unit_id', $unitIds)
            ->whereYear('tanggal', $tahun)
            ->with('category')
            ->get();

        // Flexible sum by kelompok
        $planDocVariable = $planExpenses->whereIn('category_id', $docVariableIds)->sum('jumlah');
        $planDocFixed    = $planExpenses->whereIn('category_id', $docFixedIds)->sum('jumlah');
        $planIoc         = $planExpenses->whereIn('category_id', $iocIds)->sum('jumlah');

        // Revenue actual
        $actualRevenue = PatientVisit::whereIn('unit_id', $unitIds)
            ->with('service')
            ->whereYear('tanggal', $tahun)
            ->get()
            ->sum(fn($row) => $row->jumlah_pasien * $row->service->tarif);


        // Expense actual
        $actualExpenses = Expense::whereIn('unit_id', $unitIds)
            ->whereYear('tanggal', $tahun)
            ->with('category')
            ->get();

        $actualDocVariable = $actualExpenses->whereIn('category_id', $docVariableIds)->sum('jumlah');
        $actualDocFixed    = $actualExpenses->whereIn('category_id', $docFixedIds)->sum('jumlah');
        $actualIoc         = $actualExpenses->whereIn('category_id', $iocIds)->sum('jumlah');

        // dd($targetRevenue, $targetDocVariable, $targetDocFixed, $targetIoc);

        /* ===================== TARGET ===================== */

        $targetTahunan = $targetRevenue + ($targetDocVariable + $targetDocFixed + $targetIoc);
        $targetHarian = $targetTahunan / 365;

        /* ===================== REVENUE ===================== */

        $revenueToday = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->whereBetween('pv.tanggal', [$startDate, $endDate])
            ->whereIn('pv.unit_id', $unitIds)
            ->sum(DB::raw('pv.jumlah_pasien * ms.tarif'));


        // dd($revenueToday);

        /* ===================== EXPENSE ===================== */

        $docVariable = Expense::whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('unit_id', $unitIds)
            ->whereHas('category', fn($q) => $q->where('kelompok', 'doc_variable'))
            ->sum('jumlah');

        $docFixed = Expense::whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('unit_id', $unitIds)
            ->whereHas('category', fn($q) => $q->where('kelompok', 'doc_fixed'))
            ->sum('jumlah');

        $ioc = Expense::whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('unit_id', $unitIds)
            ->whereHas('category', fn($q) => $q->where('kelompok', 'ioc'))
            ->sum('jumlah');

        $totalCost = $docVariable + $docFixed + $ioc;

        $ebitda = $revenueToday - $totalCost;

        /* ===================== BULANAN ===================== */

        $revenueBulanan = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->selectRaw('MONTH(pv.tanggal) as bulan')
            ->selectRaw('SUM(pv.jumlah_pasien * ms.tarif) as total')
            ->whereYear('pv.tanggal', $tahun)
            ->whereIn('pv.unit_id', $unitIds)
            ->groupBy(DB::raw('MONTH(pv.tanggal)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $expenseBulanan = Expense::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(jumlah) as total')
        )
            ->whereYear('tanggal', $tahun)
            ->whereIn('unit_id', $unitIds)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $ebitdaBulanan = [];

        for ($i = 1; $i <= 12; $i++) {

            $rev = $revenueBulanan[$i] ?? 0;
            $exp = $expenseBulanan[$i] ?? 0;

            $ebitdaBulanan[$i] = $rev - $exp;
        }

        /* ===================== RATIO ===================== */

        $totalRevenue = Revenue::whereIn('unit_id', $unitIds)->sum('jumlah');
        $totalExpense = Expense::whereIn('unit_id', $unitIds)->sum('jumlah');

        $costRatio = $totalRevenue > 0 ? ($totalExpense / $totalRevenue) * 100 : 0;

        $ebitdaMargin = $totalRevenue > 0 ? ($ebitda / $totalRevenue) * 100 : 0;

        $revenueTahunan = Revenue::whereYear('tanggal', $tahun)
            ->whereIn('unit_id', $unitIds)
            ->sum('jumlah');

        $progressTarget = $targetTahunan > 0
            ? ($revenueTahunan / $targetTahunan) * 100
            : 0;

        /* ===================== DAILY FINANCE ===================== */

        $days = 365;

        $daily = DailyFinance::whereIn('unit_id', $unitIds)
            ->whereDate('tanggal', $today)
            ->get();

        $planRevenue = PatientVisitTarget::whereIn('unit_id', $unitIds)
            ->with('service')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->sum(fn($row) => $row->target_pasien * $row->service->tarif);

        $planDocVariable = TargetExpense::whereIn('unit_id', $unitIds)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('category', fn($q) => $q->where('kelompok', 'DOC Variable'))
            ->sum('jumlah');

        $planDocFixed = TargetExpense::whereIn('unit_id', $unitIds)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('category', fn($q) => $q->where('kelompok', 'DOC Fixed'))
            ->sum('jumlah');

        $planIoc = TargetExpense::whereIn('unit_id', $unitIds)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('category', fn($q) => $q->where('kelompok', 'IOC'))
            ->sum('jumlah');

        /* ===================== ACTUAL ===================== */

        $actualRevenue = PatientVisit::whereIn('unit_id', $unitIds)
            ->with('service')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->sum(fn($row) => $row->jumlah_pasien * $row->service->tarif);

        $actualDocVariable = Expense::whereIn('unit_id', $unitIds)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('category', fn($q) => $q->where('kelompok', 'DOC Variable'))
            ->sum('jumlah');

        $actualDocFixed = Expense::whereIn('unit_id', $unitIds)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('category', fn($q) => $q->where('kelompok', 'DOC Fixed'))
            ->sum('jumlah');

        $actualIoc = Expense::whereIn('unit_id', $unitIds)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereHas('category', fn($q) => $q->where('kelompok', 'IOC'))
            ->sum('jumlah');

        /* ===================== EBITDA ===================== */

        $targetCost = $targetDocVariable + $targetDocFixed + $targetIoc;
        $planCost = $planDocVariable + $planDocFixed + $planIoc;
        $actualCost = $actualDocVariable + $actualDocFixed + $actualIoc;

        $targetEbitda = $targetRevenue - $targetCost;
        $planEbitda = $planRevenue - $planCost;
        $actualEbitda = $actualRevenue - $actualCost;

        $targetRevenueDaily     = $targetRevenue / $days;
        $targetDocVariableDaily = $targetDocVariable / $days;
        $targetDocFixedDaily    = $targetDocFixed / $days;
        $targetIocDaily         = $targetIoc / $days;

        $targetCostDaily        = $targetCost / $days;
        $targetEbitdaDaily      = $targetEbitda / $days;

        $targetMargin = $targetRevenue > 0 ? ($targetEbitda / $targetRevenue) * 100 : 0;
        $targetMarginDaily = $targetRevenueDaily > 0 ? ($targetEbitdaDaily / $targetRevenueDaily) * 100 : 0;
        $planMargin = $planRevenue > 0 ? ($planEbitda / $planRevenue) * 100 : 0;
        $actualMargin = $actualRevenue > 0 ? ($actualEbitda / $actualRevenue) * 100 : 0;



        /* ===================== DASHBOARD UNIT ===================== */

        // $revenues = DB::table('patient_visits as pv')
        //     ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
        //     ->selectRaw('pv.unit_id, SUM(pv.jumlah_pasien * ms.tarif) as revenue')
        //     ->groupBy('pv.unit_id')
        //     ->pluck('revenue', 'pv.unit_id');

        $revenues = DB::table('patient_visits as pv')
            ->join('medical_services as ms', 'ms.id', '=', 'pv.service_id')
            ->selectRaw('pv.unit_id, SUM(pv.jumlah_pasien * ms.tarif) as revenue')
            ->whereBetween('pv.tanggal', [$startDate, $endDate])
            ->groupBy('pv.unit_id')
            ->pluck('revenue', 'pv.unit_id');

        // $expenses = Expense::selectRaw('unit_id, SUM(jumlah) as expense')
        //     ->groupBy('unit_id')
        //     ->pluck('expense', 'unit_id');

        $expenses = Expense::selectRaw('unit_id, SUM(jumlah) as expense')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('unit_id')
            ->pluck('expense', 'unit_id');

        $positions = Position::with('unit')->get();

        $positionTree = $this->buildPositionTree($positions);

        $positionTree = $this->mapFinancePosition($positionTree, $revenues, $expenses);

        $revenueChart = [];
        $expenseChart = [];
        $ebitdaChart = [];

        for ($i = 1; $i <= 12; $i++) {

            $rev = $revenueBulanan[$i] ?? 0;
            $exp = $expenseBulanan[$i] ?? 0;
            $ebit = $ebitdaBulanan[$i] ?? 0;

            $revenueChart[] = $rev;
            $expenseChart[] = $exp;
            $ebitdaChart[] = $ebit;
        }

        // dd($unitFinance);
        // dd($targetRevenue, $targetDocVariable, $targetDocFixed, $targetIoc);

        return view('dashboard.dashboard_index', compact(
            'targetTahunan',
            'targetHarian',
            'revenueToday',
            'docVariable',
            'docFixed',
            'ioc',
            'totalCost',
            'ebitda',
            'revenueBulanan',
            'ebitdaBulanan',
            'targetRevenue',
            'actualRevenue',
            'targetDocVariable',
            'targetDocFixed',
            'targetIoc',
            'actualDocVariable',
            'actualDocFixed',
            'actualIoc',
            'targetCost',
            'actualCost',
            'targetEbitda',
            'actualEbitda',
            'targetMargin',
            'actualMargin',
            // 'unitFinance',
            'ebitdaMargin',
            'costRatio',
            'progressTarget',
            'planRevenue',
            'planDocVariable',
            'planDocFixed',
            'planIoc',
            'planCost',
            'planEbitda',
            'planMargin',
            'positionTree',

            'targetRevenueDaily',
            'targetDocVariableDaily',
            'targetDocFixedDaily',
            'targetIocDaily',
            'targetCostDaily',
            'targetEbitdaDaily',
            'targetMarginDaily',

            'revenueChart',
            'expenseChart',
            'ebitdaChart',
        ));
    }

    private function getChildPositions($id)
    {
        $children = Position::where('parent_id', $id)->get();

        $ids = [];

        foreach ($children as $child) {

            $ids[] = $child->id;

            $ids = array_merge(
                $ids,
                $this->getChildPositions($child->id)
            );
        }

        return $ids;
    }

    private function buildPositionTree($positions, $parentId = null)
    {
        $branch = [];

        foreach ($positions as $position) {

            if ($position->parent_id == $parentId) {

                $children = $this->buildPositionTree($positions, $position->id);

                if ($children) {
                    $position->children = $children;
                } else {
                    $position->children = [];
                }

                $branch[] = $position;
            }
        }

        return $branch;
    }

    private function mapFinancePosition($nodes, $revenues, $expenses)
    {
        foreach ($nodes as $node) {

            $unitId = $node->unit_id ?? null;

            $node->revenue = $revenues[$unitId] ?? 0;
            $node->expense = $expenses[$unitId] ?? 0;

            if (!empty($node->children)) {

                $node->children = $this->mapFinancePosition($node->children, $revenues, $expenses);

                // akumulasi child
                foreach ($node->children as $child) {

                    $node->revenue += $child->revenue;
                    $node->expense += $child->expense;
                }
            }

            $node->ebitda = $node->revenue - $node->expense;
        }

        return $nodes;
    }


    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role == 'pj_unit') {

            $unitIds = Unit::where('pj_user_id', $user->id)->pluck('id');
        } elseif ($user->role == 'ksp') {

            $pjIds = User::where('parent_id', $user->id)->pluck('id');
            $unitIds = Unit::whereIn('pj_user_id', $pjIds)->pluck('id');
        } elseif ($user->role == 'kabag') {

            $kspIds = User::where('parent_id', $user->id)->pluck('id');

            $pjIds = User::whereIn('parent_id', $kspIds)->pluck('id');

            $unitIds = Unit::whereIn('pj_user_id', $pjIds)->pluck('id');
        } else {

            $unitIds = Unit::pluck('id'); // admin lihat semua

        }

        $revenues = Revenue::whereIn('unit_id', $unitIds)->get();

        return view('dashboard', compact('revenues'));
    }
}
