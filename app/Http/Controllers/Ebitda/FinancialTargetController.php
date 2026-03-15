<?php

namespace App\Http\Controllers\Ebitda;

use App\Http\Controllers\Controller;
use App\Models\Ebitda\ExpenseCategory;
use App\Models\Ebitda\FinancialTargets;
use App\Models\Ebitda\RevenueCategory;
use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Http\Request;

class FinancialTargetController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->tahun ?? now()->year;

        $units = Unit::orderBy('nama_unit')->get();

        $revenueCategories = RevenueCategory::all(['id', 'nama']); // ambil semua revenue categories
        $expenseCategories = ExpenseCategory::all(['id', 'kelompok', 'nama']); // ambil semua expense categories lengkap

        $targets = FinancialTargets::with('unit')
            ->where('tahun', $year)
            ->orderBy('unit_id')
            ->get();

        return view('financial_targets.index', compact(
            'targets',
            'year',
            'units',
            'revenueCategories',
            'expenseCategories'
        ));
    }


    public function create()
    {
        $revenueCategories = RevenueCategory::all(['id', 'nama']);

        // Expense, kita ambil semua kategori tapi kirim array of objects (id + kelompok)
        $expenseCategories = ExpenseCategory::all(['id', 'kelompok']);

        return view('financial_targets.create', compact('revenueCategories', 'expenseCategories'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tahun' => 'required|integer',
            'category_type' => 'required|in:revenue,expense',
            'category_id' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        FinancialTargets::create([
            'unit_id' => $request->unit_id,
            'tahun' => $request->tahun,
            'category_type' => $request->category_type,
            'category_id' => $request->category_id,
            'amount' => $request->amount
        ]);

        return redirect()
            ->route('financial-targets.index')
            ->with('success', 'Target berhasil disimpan');
    }


    public function edit($id)
    {
        $target = FinancialTargets::findOrFail($id);
        $units = Unit::orderBy('nama_unit')->get();

        return view('financial_targets.edit', compact('target', 'units'));
    }


    public function update(Request $request, $id)
    {
        $target = FinancialTargets::findOrFail($id);

        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tahun' => 'required|integer',
            'category_type' => 'required|in:revenue,expense',
            'category_id' => 'required',
            'amount' => 'required|numeric|min:0'
        ]);

        $target->update([
            'unit_id' => $request->unit_id,
            'tahun' => $request->tahun,
            'category_type' => $request->category_type,
            'category_id' => $request->category_id,
            'amount' => $request->amount
        ]);

        return redirect()
            ->route('financial-targets.index')
            ->with('success', 'Target berhasil diperbarui');
    }


    public function destroy($id)
    {
        FinancialTargets::destroy($id);

        return back()->with('success', 'Target dihapus');
    }
}
