<?php

namespace App\Models\Ebitda;

use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyFinance extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'daily_finances';

    protected $fillable = [
        'unit_id',
        'tanggal',

        'target_revenue',
        'target_doc_variable',
        'target_doc_fixed',
        'target_ioc',

        'plan_revenue',
        'plan_doc_variable',
        'plan_doc_fixed',
        'plan_ioc',
    ];

    protected $casts = [
        'tanggal' => 'date',

        'target_revenue' => 'decimal:2',
        'target_doc_variable' => 'decimal:2',
        'target_doc_fixed' => 'decimal:2',
        'target_ioc' => 'decimal:2',

        'plan_revenue' => 'decimal:2',
        'plan_doc_variable' => 'decimal:2',
        'plan_doc_fixed' => 'decimal:2',
        'plan_ioc' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER CALCULATION
    |--------------------------------------------------------------------------
    */

    public function getTargetCostAttribute()
    {
        return $this->target_doc_variable
            + $this->target_doc_fixed
            + $this->target_ioc;
    }

    public function getPlanCostAttribute()
    {
        return $this->plan_doc_variable
            + $this->plan_doc_fixed
            + $this->plan_ioc;
    }

    public function getTargetEbitdaAttribute()
    {
        return $this->target_revenue - $this->target_cost;
    }

    public function getPlanEbitdaAttribute()
    {
        return $this->plan_revenue - $this->plan_cost;
    }

    public function getTargetMarginAttribute()
    {
        if ($this->target_revenue == 0) {
            return 0;
        }

        return ($this->target_ebitda / $this->target_revenue) * 100;
    }

    public function getPlanMarginAttribute()
    {
        if ($this->plan_revenue == 0) {
            return 0;
        }

        return ($this->plan_ebitda / $this->plan_revenue) * 100;
    }
}
