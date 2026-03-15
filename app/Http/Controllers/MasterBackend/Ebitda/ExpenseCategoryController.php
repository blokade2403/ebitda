<?php

namespace App\Http\Controllers\MasterBackend\Ebitda;

use App\Http\Controllers\Controller;
use App\Imports\ExpenseCategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Ebitda\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExpenseCategoryController extends Controller
{

    public function index()
    {
        $categories = ExpenseCategory::orderBy('nama')->get();

        $parents = ExpenseCategory::whereNull('parent_id')
            ->where('is_active', 1)
            ->orderBy('nama')
            ->get();

        return view('expenses.expensecategory.index', compact('categories', 'parents'), [
            'title'         => 'Kategori Expense',
            'routePrefix'   => 'expense_categories'
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|in:DOC Variable,DOC Fixed,IOC',
            'is_active' => 'boolean'
        ]);

        ExpenseCategory::create([
            'id' => Str::uuid(),
            'parent_id' => $request->parent_id,
            'nama' => $request->nama,
            'kelompok' => $request->kelompok,
            'is_active' => $request->is_active ?? false
        ]);

        return back()->with('success', 'Kategori expense berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kelompok' => 'required',
            'parent_id' => 'nullable|exists:expense_categories,id',
            'is_active' => 'boolean'
        ]);

        $category = ExpenseCategory::findOrFail($id);

        $category->update([
            'nama' => $request->nama,
            'kelompok' => $request->kelompok,
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active ? true : false
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }


    public function destroy($id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }

    public function importExpenseCategory(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new ExpenseCategoryImport, $request->file('file'));

        return back()->with('success', 'Data kategori berhasil diimport');
    }
}
