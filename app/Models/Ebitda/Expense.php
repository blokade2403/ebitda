<?php

namespace App\Models\Ebitda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_id',
        'expense_category_id',
        'tanggal',
        'jumlah',
        'keterangan',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}
