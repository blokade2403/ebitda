<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FinanceHierarchyPrettyExport implements FromArray, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {

        $d = $this->data;

        return [

            ['', 'Direktur', '', '', '', '', ''],

            ['', 'TOP DOWN', '', 'BOTTOM UP', '', 'BUDGET 2025', ''],

            [
                '',
                'Target/Tahun',
                'Target Harian',
                'Rencana Harian',
                'Aktual Harian',
                'Target/Tahun',
                'Target Harian'
            ],

            [
                'Pendapatan',
                $d['revenue_year'],
                $d['revenue_daily'],
                $d['plan_daily'],
                $d['actual_daily'],
                $d['budget_year'],
                $d['budget_daily']
            ],

            [
                'DOC Variable',
                $d['doc_variable'],
                '',
                '',
                '',
                '',
                ''
            ],

            [
                'DOC Fixed',
                $d['doc_fixed'],
                '',
                '',
                '',
                '',
                ''
            ],

            [
                'IOC',
                $d['ioc'],
                '',
                '',
                '',
                '',
                ''
            ],

            [
                'Total Op Costs',
                $d['total_cost'],
                '',
                '',
                '',
                '',
                ''
            ],

            [
                'EBITDA',
                $d['ebitda'],
                '',
                '',
                '',
                '',
                ''
            ],

            [
                'EBITDA Margin',
                $d['margin'],
                '',
                '',
                '',
                '',
                ''
            ],

        ];
    }

    public function styles(Worksheet $sheet)
    {

        /* HEADER HIJAU */

        $sheet->getStyle('B1:G3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '6A9E42'
                ]
            ]
        ]);

        /* EBITDA MARGIN KUNING */

        $sheet->getStyle('A10:G10')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFF200'
                ]
            ]
        ]);

        /* BOLD EBITDA */

        $sheet->getStyle('A9:G9')->getFont()->setBold(true);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20
        ];
    }
}
