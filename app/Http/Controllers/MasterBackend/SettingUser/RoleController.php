<?php

namespace App\Http\Controllers\MasterBackend\SettingUser;

use App\Http\Controllers\Controller;
use App\Models\MasterBackend\SettingUser\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// use function Pest\Laravel\session;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('nama_role')->get();

        return view('master_backend.setting_users.role.index', compact('roles'), [
            'routePrefix' => 'roles',
            'title' => 'Halaman Role',
            'title2' => 'Role',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role',
        ]);

        Role::create([
            'id' => Str::uuid(),
            'nama_role' => $request->nama_role,
        ]);

        return back()->with('success', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role,' . $id,
        ]);

        $role->update([
            'nama_role' => $request->nama_role,
        ]);

        return back()->with('success', 'Role berhasil diupdate');
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return back()->with('success', 'Role berhasil dihapus');
    }
}
