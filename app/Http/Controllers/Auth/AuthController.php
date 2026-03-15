<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MasterBackend\SettingInput\TahunAnggaran;
use App\Models\MasterBackend\SettingUser\Position;
use App\Models\MasterBackend\SettingUser\Unit;
use App\Models\MasterBackend\UserProfil\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        $tahun = TahunAnggaran::where('status', 'aktif')->get();

        return view('login.index', compact('tahun'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Username atau password salah.');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        /** @var \App\Models\MasterBackend\UserProfil\User $user */
        $user = Auth::user();

        $user->load(['roles', 'unit', 'position']);

        // CEK STATUS USER
        if ($user->status_user !== 'aktif') {
            Auth::logout();
            return back()->with('error', 'User tidak aktif.');
        }

        // AMBIL ROLE
        $roles = $user->roles->pluck('nama_role')->toArray();
        $role_ids = $user->roles->pluck('id')->toArray();

        // AMBIL TAHUN ANGGARAN
        $tahun = TahunAnggaran::with('fase')->find($request->tahun_anggaran_id);

        if (!$tahun) {
            Auth::logout();
            return back()->with('error', 'Tahun anggaran tidak valid.');
        }

        // SESSION USER
        Session::put('user_id', $user->id);
        Session::put('nip', $user->nip);
        Session::put('nama', $user->nama);
        Session::put('unit_id', $user->unit_id);
        Session::put('position_id', $user->position_id);

        Session::put('nama_jabatan', $user->position?->nama_jabatan);
        Session::put('nama_unit', $user->unit?->nama_unit);

        Session::put('tahun_anggaran', $tahun->nama_tahun);
        Session::put('fase_tahun_anggaran', $tahun->fase?->nama_fase);
        Session::put('fase_tahun_anggaran_id', $tahun->fase_id);

        Session::put('roles', $roles);
        Session::put('role_ids', $role_ids);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();

        return redirect()->route('login.form');
    }
}
