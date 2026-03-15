<?php

namespace App\Models\Ebitda;

use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_id',
        'tahun',
        'target_revenue',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
