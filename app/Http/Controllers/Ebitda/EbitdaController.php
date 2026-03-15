<?php

namespace App\Http\Controllers\Ebitda;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EbitdaController extends Controller
{
    public function dashboard(Request $request)
    {
        $start = $request->start ?? Carbon::now()->startOfMonth();
        $end = $request->end ?? Carbon::now()->endOfMonth();

        $revenue = DB::table('revenues')
            ->whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        $operasional = DB::table('expenses')
            ->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->where('expense_categories.kelompok', 'operasional')
            ->whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        $depresiasi = DB::table('expenses')
            ->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->where('expense_categories.kelompok', 'depresiasi')
            ->whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        $bunga = DB::table('expenses')
            ->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->where('expense_categories.kelompok', 'bunga')
            ->whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        $pajak = DB::table('expenses')
            ->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->where('expense_categories.kelompok', 'pajak')
            ->whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        $ebitda = $revenue - $operasional;

        return view('dashboard.ebitda', compact(
            'revenue',
            'operasional',
            'depresiasi',
            'bunga',
            'pajak',
            'ebitda'
        ));
    }
}
