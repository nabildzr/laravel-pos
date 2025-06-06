<?php

namespace App\Exports;

use App\Models\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductSalesReportExport implements FromCollection, WithHeadings, WithStyles
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
        return TransactionDetail::with(['product', 'transaction.user'])
            ->whereHas('transaction', function($q) {
                $q->whereBetween('created_at', [$this->from, $this->to]);
            })
            ->get()
            ->map(function ($detail) {
                return [
                    $detail->product ? $detail->product->name : $detail->product_name,
                    $detail->product ? $detail->product->sku : '',
                    $detail->quantity,
                    $detail->price,
                    $detail->product && $detail->product->is_discount ? $detail->product->discount : 'Tidak ada diskon',
                    $detail->total,
                    $detail->transaction ? $detail->transaction->created_at->format('Y-m-d H:i:s') : '',
                    $detail->transaction && $detail->transaction->user ? $detail->transaction->user->name : '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'SKU',
            'Jumlah',
            'Harga Satuan',
            'Diskon',
            'Subtotal',
            'Tanggal Transaksi',
            'Kasir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count() + 1;
        $colCount = 8;
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