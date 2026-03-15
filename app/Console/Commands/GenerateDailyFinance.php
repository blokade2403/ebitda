<?php

namespace App\Console\Commands;

use App\Models\Ebitda\DailyFinance;
use App\Models\Ebitda\Expense;
use App\Models\Ebitda\Revenue;
use App\Models\MasterBackend\SettingUser\Unit;
use Illuminate\Console\Command;

class GenerateDailyFinance extends Command
{
    protected $signature = 'finance:generate-daily';

    protected $description = 'Generate daily finance summary from revenues and expenses';

    public function handle()
    {
        $tanggal = now()->toDateString();

        $units = Unit::all();

        foreach ($units as $unit) {

            $revenue = Revenue::where('unit_id', $unit->id)
                ->whereDate('tanggal', $tanggal)
                ->sum('jumlah');

            $docVariable = Expense::where('unit_id', $unit->id)
                ->whereDate('tanggal', $tanggal)
                ->whereHas('category', function ($q) {
                    $q->where('kelompok', 'DOC Variable');
                })
                ->sum('jumlah');

            $docFixed = Expense::where('unit_id', $unit->id)
                ->whereDate('tanggal', $tanggal)
                ->whereHas('category', function ($q) {
                    $q->where('kelompok', 'DOC Fixed');
                })
                ->sum('jumlah');

            $ioc = Expense::where('unit_id', $unit->id)
                ->whereDate('tanggal', $tanggal)
                ->whereHas('category', function ($q) {
                    $q->where('kelompok', 'IOC');
                })
                ->sum('jumlah');


            DailyFinance::updateOrCreate(

                [
                    'unit_id' => $unit->id,
                    'tanggal' => $tanggal
                ],

                [
                    'plan_revenue' => $revenue,
                    'plan_doc_variable' => $docVariable,
                    'plan_doc_fixed' => $docFixed,
                    'plan_ioc' => $ioc
                ]
            );
        }

        $this->info('Daily finance generated successfully.');
    }
}
