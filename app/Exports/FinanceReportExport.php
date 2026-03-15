<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinanceReportExport implements WithMultipleSheets
{
    protected $summary;
    protected $monthly;
    protected $expenseCategory;
    protected $revenueService;

    public function __construct($summary, $monthly, $expenseCategory, $revenueService)
    {
        $this->summary = $summary;
        $this->monthly = $monthly;
        $this->expenseCategory = $expenseCategory;
        $this->revenueService = $revenueService;
    }

    public function sheets(): array
    {
        return [
            new FinanceSummarySheet($this->summary),
            new MonthlyEbitdaSheet($this->monthly),
            new ExpenseCategorySheet($this->expenseCategory),
            new RevenueServiceSheet($this->revenueService),
        ];
    }
}
