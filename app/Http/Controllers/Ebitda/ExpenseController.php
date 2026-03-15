<?php

namespace App\Http\Controllers\Ebitda;

use App\Http\Controllers\Controller;
use App\Models\Ebitda\Expense;
use App\Models\Ebitda\ExpenseCategory;
use App\Models\MasterBackend\SettingUser\Unit;
use App\Models\MasterBackend\UserProfil\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $roles = session('roles', []);
        if (in_array('Admin', $roles)) {

            // ADMIN lihat semua unit
            $query = Expense::with('category');
        } else {

            // USER mengikuti hierarchy
            $myPosition = $user->position_id;
            $childPositions = getChildPositions($myPosition);
            $allPositions = $childPositions->push($myPosition);

            $unitIds = User::whereIn('position_id', $allPositions)
                ->pluck('unit_id');

            $units = Unit::whereIn('id', $unitIds)->get();

            $query = Expense::with('category')
                ->whereIn('unit_id', $unitIds);
        }

        // FILTER TANGGAL (semua role)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // FILTER KATEGORI
        if ($request->filled('expense_category_id')) {
            $query->where('expense_category_id', $request->expense_category_id);
        }

        // CLONE QUERY UNTUK SUM
        $totalJumlah = (clone $query)->sum('jumlah');

        $expenses = $query->orderBy('tanggal', 'desc')->get();
        $categories = ExpenseCategory::where('is_active', true)->get();

        return view('expenses.index', compact('expenses', 'categories', 'totalJumlah'), [
            'routePrefix' => 'expenses',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Expense::create([
            'id' => Str::uuid(),
            'expense_category_id' => $request->expense_category_id,
            'unit_id' => auth()->user()->unit_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Beban berhasil disimpan');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
