<?php

namespace App\Models\MasterBackend\SettingInput;

use App\Models\MasterBackend\SettingUser\Fase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAnggaran extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['nama_tahun', 'fase_id', 'status'];

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id', 'id');
    }
}
