<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Collection;

class LaporanKinerjaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnWidths,
    WithEvents
{
    protected Collection $data;
    protected string $periode;
    protected int $row = 1;

    public function __construct(Collection $data, string $periode)
    {
        $this->data    = $data;
        $this->periode = $periode;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Obat',
            'Merek',
            'Dosis (mg)',
            'Jenis',
            'Total Pemakaian',
            'Frekuensi',
        ];
    }

    public function map($row): array
    {
        return [
            $this->row++,
            $row->nama_obat,
            $row->nama_merek,
            $row->dosis_mg,
            $row->jenis,
            $row->total,
            $row->frekuensi,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 24,
            'C' => 20,
            'D' => 12,
            'E' => 16,
            'F' => 18,
            'G' => 12,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F6E56']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet   = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = 'G';

                // Border
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setRGB('D1D5DB');

                // Freeze header
                $sheet->freezePane('A2');

                // Zebra stripe
                for ($i = 2; $i <= $lastRow; $i++) {
                    if ($i % 2 === 0) {
                        $sheet->getStyle("A{$i}:{$lastCol}{$i}")
                            ->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F0FDF4');
                    }
                }

                // Format angka
                $sheet->getStyle("F2:G{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');

                // Total row
                $totalRow = $lastRow + 1;
                $sheet->setCellValue("E{$totalRow}", 'TOTAL');
                $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F{$lastRow})");
                $sheet->getStyle("A{$totalRow}:{$lastCol}{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D9E75']],
                ]);
                $sheet->getStyle("F{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');

                // Judul
                $sheet->insertNewRowBefore(1, 3);
                $sheet->setCellValue('A1', 'LAPORAN KINERJA FARMASI — Klinik Yos Benito');
                $sheet->setCellValue('A2', 'Periode: ' . $this->periode);
                $sheet->setCellValue('A3', 'Dicetak: ' . now()->format('d/m/Y H:i'));

                foreach (['A1', 'A2', 'A3'] as $cell) {
                    $sheet->mergeCells("{$cell}:{$lastCol}" . substr($cell, 1));
                }

                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '0F6E56']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('A2:A3')->applyFromArray([
                    'font'      => ['size' => 10, 'color' => ['rgb' => '6B7280']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getRowDimension(1)->setRowHeight(24);
                $sheet->getRowDimension(4)->setRowHeight(22);
            },
        ];
    }

    public function title(): string
    {
        return 'Laporan Kinerja';
    }
}
