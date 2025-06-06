<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExpensesExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */


    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return Expense::whereBetween('created_at', [$this->from, $this->to])
        ->with(['user', 'approver']) // pastikan relasi user dan approver ada di model Expense
        ->select('id', 'date', 'created_at', 'proof', 'amount', 'description', 'approved_by', 'approved_at', 'created_by', 'status')
        ->get()
        ->map(function ($item) {
            // Format tanggal pengeluaran
            $item->date = $item->date ? \Carbon\Carbon::parse($item->date)->format('Y-m-d') : '';
            // Format created_at
            $createdAt = $item->created_at ? \Carbon\Carbon::parse($item->created_at) : null;
            $item->created_at = $createdAt ? $createdAt->format('Y-m-d H:i:s') : '';
            $item->created_at_day = $createdAt ? $createdAt->translatedFormat('F l') : '';
            // Proof jadi URL
            $item->proof = $item->proof ? asset('storage/' . $item->proof) : '';
            // Nama user pembuat
            $item->created_by = $item->user ? $item->user->name : '';
            // Nama approver
            $item->approved_by = $item->approver ? $item->approver->name : '';
            // Format approved_at
            $item->approved_at = $item->approved_at ? \Carbon\Carbon::parse($item->approved_at)->format('Y-m-d H:i:s') : '';
            return [
                $item->id,
                $item->date,
                $item->created_at,
                $item->created_at_day,
                $item->proof,
                $item->amount,
                $item->description,
                $item->approved_by,
                $item->approved_at,
                $item->created_by,
                $item->status,
            ];
        });
        }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Pengeluaran',
            'Tanggal Dibuat',
            'Hari Dibuat',
            'Bukti',
            'Jumlah',
            'Deskripsi',
            'Disetujui Oleh',
            'Disetujui Pada',
            'Dibuat Oleh',
            'Status'
        ];
    }





    // styles
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count() + 1;
        $colCount = 11;

        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

        // Apply border to all cells
        $sheet->getStyle("A1:{$lastCol}{$rowCount}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Bold, center, and color for heading
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
                    'rgb' => '0070C0', // Blue color
                ],
            ],
        ]);

        return [];
    }
}
