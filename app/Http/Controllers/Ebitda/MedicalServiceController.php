<?php

namespace App\Http\Controllers\Ebitda;

use App\Http\Controllers\Controller;
use App\Imports\MedicalServiceImport;
use App\Models\Ebitda\MedicalService;
use App\Models\Ebitda\RevenueCategory;
use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MedicalServiceController extends Controller
{

    public function index()
    {
        $services = MedicalService::with(['unit', 'category'])
            ->orderBy('nama_layanan')
            ->get();

        $units = Unit::all();

        $categories = RevenueCategory::where('is_active', true)->get();

        return view('revenues.medicalservices.index', compact(
            'services',
            'units',
            'categories'
        ));
    }


    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'revenue_category_id' => 'required|exists:revenue_categories,id',
            'nama_layanan' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0'
        ]);

        MedicalService::create([
            'id' => Str::uuid(),
            'unit_id' => $request->unit_id,
            'revenue_category_id' => $request->revenue_category_id,
            'nama_layanan' => $request->nama_layanan,
            'tarif' => $request->tarif,
            'is_active' => true
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan');
    }


    // UPDATE DATA
    public function update(Request $request, $id)
    {

        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'revenue_category_id' => 'required|exists:revenue_categories,id',
            'nama_layanan' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0'
        ]);

        $service = MedicalService::findOrFail($id);

        $service->update([
            'unit_id' => $request->unit_id,
            'revenue_category_id' => $request->revenue_category_id,
            'nama_layanan' => $request->nama_layanan,
            'tarif' => $request->tarif
        ]);

        return back()->with('success', 'Layanan berhasil diupdate');
    }


    // HAPUS DATA
    public function destroy($id)
    {

        $service = MedicalService::findOrFail($id);

        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus');
    }

    public function importMedicalService(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new MedicalServiceImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diupload');
    }
}
