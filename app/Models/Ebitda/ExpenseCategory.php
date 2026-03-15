<?php

namespace App\Models\Ebitda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'parent_id',
        'nama',
        'kelompok',
        'is_active'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function parent()
    {
        return $this->belongsTo(ExpenseCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ExpenseCategory::class, 'parent_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
