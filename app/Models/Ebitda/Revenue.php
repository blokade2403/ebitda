<?php

namespace App\Models\Ebitda;

use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_id',
        'revenue_category_id',
        'tanggal',
        'jumlah',
        'keterangan',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function category()
    {
        return $this->belongsTo(RevenueCategory::class, 'revenue_category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
