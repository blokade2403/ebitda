<?php

namespace App\Models\Ebitda;

use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTargets extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'financial_targets';

    protected $fillable = [
        'unit_id',
        'tahun',
        'category_type', // revenue / expense
        'category_id',   // id dari tabel revenue_categories atau expense_categories
        'amount'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'amount' => 'decimal:2'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function revenueCategory()
    {
        return $this->belongsTo(RevenueCategory::class, 'category_id');
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function getCategoryNameAttribute()
    {
        if ($this->category_type === 'revenue' && $this->revenueCategory) {
            return $this->revenueCategory->nama;
        }

        if ($this->category_type === 'expense' && $this->expenseCategory) {
            return $this->expenseCategory->kelompok;
        }

        return null;
    }
}
