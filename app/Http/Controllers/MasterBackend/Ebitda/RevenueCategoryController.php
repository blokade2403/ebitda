<?php

namespace App\Http\Controllers\MasterBackend\Ebitda;

use App\Http\Controllers\Controller;
use App\Models\Ebitda\RevenueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RevenueCategoryController extends Controller
{

    public function index()
    {
        $categories = RevenueCategory::orderBy('nama')->get();

        return view('revenues.revenuecategory.index', compact('categories'), [
            'title'         => 'Kategori Revenue',
            'routePrefix'   => 'revenue_categories'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        RevenueCategory::create([
            'id' => Str::uuid(),
            'nama' => $request->nama,
            'is_active' => $request->is_active ?? false
        ]);

        return back()->with('success', 'Kategori revenue berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'is_active' => 'boolean'
        ]);

        $category = RevenueCategory::findOrFail($id);

        $category->update([
            'nama' => $request->nama,
            'is_active' => $request->is_active ? true : false
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }


    public function destroy($id)
    {
        $category = RevenueCategory::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
