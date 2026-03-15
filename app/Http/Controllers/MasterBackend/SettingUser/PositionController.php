<?php

namespace App\Http\Controllers\MasterBackend\SettingUser;

use App\Http\Controllers\Controller;
use App\Models\MasterBackend\SettingUser\Position;
use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('parent', 'unit')->orderBy('nama_jabatan')->get();
        $units = Unit::all();
        $position = Position::all();
        return view('master_backend.setting_users.positions.index', compact('positions', 'position', 'units'), [
            'routePrefix' => 'positions',
            'title' => 'Halaman Jabatan',
            'title2' => 'Jabatan',
        ]);
    }

    public function create()
    {
        $parents = Position::orderBy('nama_jabatan')->get();
        $units = Unit::orderBy('nama_unit')->get();

        return view('master_backend.setting_users.positions.create', compact('parents', 'units'), [
            'routePrefix' => 'positions',
            'title' => 'Halaman Jabatan',
            'title2' => 'Jabatan',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'parent_id' => 'nullable|exists:positions,id',
        ]);

        Position::create([
            'id' => Str::uuid(),
            'nama_jabatan' => $request->nama_jabatan,
            'parent_id' => $request->parent_id,
            'unit_id' => $request->unit_id,
        ]);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        $parents = Position::where('id', '!=', $id)->get();

        return view('master_backend.setting_users.positions.edit', compact('position', 'parents'), [
            'routePrefix' => 'positions',
            'title' => 'Halaman Jabatan',
            'title2' => 'Jabatan',
        ]);
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:positions,id',
        ]);

        // Hindari parent = dirinya sendiri
        if ($request->parent_id == $id) {
            return back()->with('error', 'Parent tidak boleh dirinya sendiri');
        }

        $position->update([
            'nama_jabatan' => $request->nama_jabatan,
            'parent_id' => $request->parent_id,
            'unit_id' => $request->unit_id,
        ]);

        return redirect()->route('positions.index')->with('success', 'Jabatan berhasil diupdate');
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);

        // Cek apakah masih punya bawahan
        if ($position->children()->count() > 0) {
            return back()->with('error', 'Tidak bisa hapus, masih memiliki bawahan');
        }

        $position->delete();

        return redirect()->route('positions.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
