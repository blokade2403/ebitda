<?php

namespace App\Models\Ebitda;

use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PatientVisitTarget extends Model
{
    use HasFactory;
    protected $table = 'patient_visit_targets';

    protected $fillable = [
        'id',
        'unit_id',
        'service_id',
        'tanggal',
        'target_pasien'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(MedicalService::class, 'service_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
