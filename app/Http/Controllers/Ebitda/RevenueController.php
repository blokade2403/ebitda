<?php

namespace App\Http\Controllers\Ebitda;

use App\Http\Controllers\Controller;
use App\Models\Ebitda\MedicalService;
use App\Models\Ebitda\PatientVisit;
use App\Models\Ebitda\Revenue;
use App\Models\Ebitda\RevenueCategory;
use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RevenueController extends Controller
{
    // Tampilkan daftar & form input
    public function index(Request $request)
    {
        $unitId = Auth::user()->unit_id;

        $query = Revenue::with(['category', 'unit'])
            ->where('unit_id', $unitId);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [
                $request->start_date,
                $request->end_date,
            ]);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $revenues = $query->orderBy('tanggal', 'desc')->get();

        $categories = RevenueCategory::where('is_active', true)->get();
        $units = Unit::orderBy('nama_unit')->get();

        return view('revenues.index', compact(
            'revenues',
            'categories', 'units'
        ));
    }

    public function storeVisit(Request $request)
{

$service = MedicalService::find($request->service_id);

$revenue = $request->jumlah_pasien * $service->tarif;

PatientVisit::create([
'id' => Str::uuid(),
'unit_id' => auth()->user()->unit_id,
'service_id' => $request->service_id,
'tanggal' => $request->tanggal,
'jumlah_pasien' => $request->jumlah_pasien
]);

Revenue::create([
'id' => Str::uuid(),
'unit_id' => auth()->user()->unit_id,
'service_id' => $request->service_id,
'tanggal' => $request->tanggal,
'jumlah' => $revenue
]);

}

    // Simpan data harian
    public function store(Request $request)
    {

        $request->validate([
            'tanggal' => 'required|date',
            'revenue_category_id' => 'required|exists:revenue_categories,id',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Revenue::create([
            'id' => Str::uuid(),
            'unit_id' => session()->get('unit_id'),
            'revenue_category_id' => $request->revenue_category_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pendapatan berhasil disimpan');
    }

    // Hapus data
    public function destroy($id)
    {
        Revenue::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
