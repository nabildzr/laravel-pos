<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionInfoExport implements FromCollection, WithHeadings, WithStyles
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return Transaction::with(['user', 'paymentMethod', 'member'])
            ->whereBetween('created_at', [$this->from, $this->to])
            ->get()
            ->map(function ($trx) {
                return [
                    $trx->id,
                    $trx->created_at ? $trx->created_at->format('Y-m-d H:i:s') : '',
                    $trx->user ? $trx->user->name : '',
                    $trx->member ? $trx->member->name : 'Tanpa Member',
                    $trx->paymentMethod ? $trx->paymentMethod->name : '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal & Waktu',
            'Kasir',
            'Member',
            'Metode Pembayaran',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count() + 1;
        $colCount = 5;
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

        // Border
        $sheet->getStyle("A1:{$lastCol}{$rowCount}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Heading style
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '0070C0',
                ],
            ],
        ]);

        return [];
    }
}
