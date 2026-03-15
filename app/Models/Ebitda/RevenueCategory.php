<?php

namespace App\Models\Ebitda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueCategory extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nama', 'is_active'];

    public $incrementing = false;

    protected $keyType = 'string';

    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }
}
