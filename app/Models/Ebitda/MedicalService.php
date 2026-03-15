<?php

namespace App\Models\Ebitda;

use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_id',
        'revenue_category_id',
        'nama_layanan',
        'tarif',
        'is_active'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(RevenueCategory::class, 'revenue_category_id');
    }

    public function visits()
    {
        return $this->hasMany(PatientVisit::class, 'service_id');
    }
}
