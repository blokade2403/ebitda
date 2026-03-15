<?php

namespace App\Imports;

use App\Models\Ebitda\MedicalService;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicalServiceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new MedicalService([
            'id' => Str::uuid(),
            'unit_id' => $row['unit_id'],
            'revenue_category_id' => $row['revenue_category_id'],
            'nama_layanan' => $row['nama_layanan'],
            'tarif' => $row['tarif'],
            'is_active' => $row['is_active'] ?? 1,
        ]);
    }
}
