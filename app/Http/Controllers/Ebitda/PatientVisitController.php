<?php

namespace App\Http\Controllers\Ebitda;

use App\Http\Controllers\Controller;
use App\Models\Ebitda\MedicalService;
use App\Models\Ebitda\PatientVisit;
use App\Models\MasterBackend\SettingUser\Position;
use App\Models\MasterBackend\SettingUser\Unit;
use App\Models\MasterBackend\UserProfil\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PatientVisitController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $roles = session('roles', []);
        $units = Unit::all();

        if (in_array('Admin', $roles)) {

            // ADMIN lihat semua unit
            $query = PatientVisit::with(['service', 'unit']);
        } else {

            // USER mengikuti hierarchy
            $myPosition = $user->position_id;
            $childPositions = getChildPositions($myPosition);
            $allPositions = $childPositions->push($myPosition);

            $unitIds = User::whereIn('position_id', $allPositions)
                ->pluck('unit_id');

            $units = Unit::whereIn('id', $unitIds)->get();

            $query = PatientVisit::with(['service', 'unit'])
                ->whereIn('unit_id', $unitIds);
        }

        // FILTER TANGGAL (semua role)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // FILTER UNIT
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // FILTER LAYANAN
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        $visits = $query->orderBy('tanggal', 'desc')->get();
        $sumTargetPasien = (clone $query)->sum('jumlah_pasien');
        $sumRevenue = $visits->sum(function ($visit) {
            return ($visit->jumlah_pasien ?? 0) * ($visit->service->tarif ?? 0);
        });

        $services = MedicalService::where('is_active', 1)->get();
        $revenu_categories = DB::table('revenue_categories')->get();

        return view('visits.index', compact(
            'visits',
            'services',
            'revenu_categories',
            'units',
            'sumTargetPasien',
            'sumRevenue'
        ), [
            'title' => 'Kunjungan Pasien',
            'routePrefix' => 'visits'
        ]);
    }

    public function index2(Request $request)
    {
        $user = auth()->user();
        $myPosition = $user->position_id;
        $role = session('roles'); // atau $user->role
        $childPositions = getChildPositions($myPosition);
        $allPositions = $childPositions->push($myPosition);
        $services = MedicalService::where('is_active', 1)->get();
        $revenu_categories = DB::table('revenue_categories')->get();

        $unitIds = User::whereIn('position_id', $allPositions)
            ->pluck('unit_id');

        // ambil unit yang boleh dilihat user
        $units = Unit::whereIn('id', $unitIds)->get();

        $query = PatientVisit::with(['service', 'unit'])
            ->whereIn('unit_id', $unitIds);

        // FILTER TANGGAL
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // FILTER UNIT
        if ($request->unit_id) {
            $query->where('unit_id', $request->unit_id);
        }

        // FILTER LAYANAN
        if ($request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        if ($role == 'Admin') {

            $visits = PatientVisit::with(['service', 'unit'])
                ->orderBy('tanggal', 'desc')
                ->get();
        } else {
            $visits = $query->whereIn('unit_id', $unitIds)->orderBy('tanggal', 'desc')->get();
        }

        return view('visits.index', compact(
            'visits',
            'services',
            'revenu_categories',
            'units'
        ), [
            'title' => 'Kunjungan Pasien',
            'routePrefix' => 'visits'
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'service_id' => 'required',
            'tanggal' => 'nullable|date',
            'jumlah_pasien' => 'required|integer|min:0'
        ]);

        PatientVisit::create([
            'unit_id' => session('unit_id'),
            'service_id' => $request->service_id,
            'tanggal' => $request->tanggal ?? Carbon::now()->toDateString(),
            'jumlah_pasien' => $request->jumlah_pasien
        ]);

        return back()->with('success', 'Data kunjungan berhasil disimpan');
    }

    public function dailyFinance($tanggal)
    {
        $services = MedicalService::where('is_active', 1)->get();

        $data = PatientVisit::with('service')
            ->whereDate('tanggal', $tanggal)
            ->get();

        $total = 0;

        foreach ($data as $row) {

            $revenue = $row->jumlah_pasien * $row->service->tarif;

            $total += $revenue;

            $row->revenue = $revenue;
        }

        return view('finance.daily', compact(
            'data',
            'total',
            'services'
        ));
    }
}
