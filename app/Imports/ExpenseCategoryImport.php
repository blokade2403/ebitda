<?php

namespace App\Imports;

use App\Models\Ebitda\ExpenseCategory;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExpenseCategoryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ExpenseCategory([
            'id' => Str::uuid(),
            'parent_id' => $row['parent_id'] ?? null,
            'nama' => $row['nama'],
            'kelompok' => $row['kelompok'] ?? null,
            'is_active' => $row['is_active'] ?? 1,
        ]);
    }
}
