<?php

namespace App\Http\Controllers\Ebitda;

use App\Http\Controllers\Controller;
use App\Models\Ebitda\MedicalService;
use App\Models\Ebitda\PatientVisit;
use App\Models\Ebitda\PatientVisitTarget;
use App\Models\MasterBackend\SettingUser\Unit;
use App\Models\MasterBackend\UserProfil\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientTargetController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $roles = session('roles', []);
        $units = Unit::all();

        if (in_array('Admin', $roles)) {

            // ADMIN lihat semua unit
            $query = PatientVisitTarget::with(['service', 'unit']);
        } else {

            // USER mengikuti hierarchy
            $myPosition = $user->position_id;
            $childPositions = getChildPositions($myPosition);
            $allPositions = $childPositions->push($myPosition);

            $unitIds = User::whereIn('position_id', $allPositions)
                ->pluck('unit_id');

            $units = Unit::whereIn('id', $unitIds)->get();

            $query = PatientVisitTarget::with(['service', 'unit'])
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

        $targets = $query->orderBy('tanggal', 'desc')->get();
        // SUM TARGET PASIEN
        $sumTargetPasien = (clone $query)->sum('target_pasien');
        $sumRevenue = $targets->sum(function ($visit) {
            return ($visit->target_pasien ?? 0) * ($visit->service->tarif ?? 0);
        });

        $services = MedicalService::where('is_active', 1)->get();
        $revenu_categories = DB::table('revenue_categories')->get();

        return view('targets.index', compact(
            'services',
            'targets',
            'revenu_categories',
            'units',
            'sumTargetPasien',
            'sumRevenue'
        ), [
            'routePrefix' => 'targets'
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'tanggal' => 'required|date',
            'target_pasien' => 'required|integer|min:0'
        ]);

        PatientVisitTarget::create([
            'unit_id' => session('unit_id'),
            'service_id' => $request->service_id,
            'tanggal' => $request->tanggal,
            'target_pasien' => $request->target_pasien
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

            $revenue = $row->target_pasien * $row->service->tarif;

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
