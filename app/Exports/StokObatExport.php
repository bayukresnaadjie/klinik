<?php

namespace App\Exports;

use App\Models\StokObat;
use Maatwebsite\Excel\Concerns\FromQuery;
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

class StokObatExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnWidths,
    WithEvents
{
    public function __construct(
        protected ?string $jenis   = null,
        protected ?string $status  = null,
        protected ?string $cari    = null,
    ) {}

    public function query()
    {
        $query = StokObat::with(['varianObat.obat.jenisObat'])
            ->orderBy('tanggal_kadaluarsa', 'asc');

        if ($this->cari) {
            $cari = $this->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('no_batch', 'like', "%{$cari}%")
                  ->orWhereHas('varianObat', fn($q2) =>
                      $q2->where('nama_merek', 'like', "%{$cari}%")
                  );
            });
        }

        if ($this->jenis && $this->jenis !== 'semua') {
            $query->whereHas('varianObat.obat.jenisObat', fn($q) =>
                $q->where('id_jenis', $this->jenis)
            );
        }

        if ($this->status && $this->status !== 'semua') {
            match ($this->status) {
                'expired'  => $query->expired(),
                'kritis'   => $query->mendekatiKadaluarsa(30),
                'ada_stok' => $query->adaStok(),
                'habis'    => $query->where('jumlah', 0),
                default    => null,
            };
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Merek',
            'Zat Aktif',
            'Jenis',
            'Dosis (mg)',
            'No. Batch',
            'Jumlah Stok',
            'Harga Satuan (Rp)',
            'Nilai Stok (Rp)',
            'Tanggal Masuk',
            'Tanggal Kadaluarsa',
            'Sisa Hari',
            'Status',
        ];
    }

    protected int $row = 1;

    public function map($row): array
    {
        return [
            $this->row++,
            $row->varianObat->nama_merek ?? '-',
            $row->varianObat->obat->nama_obat ?? '-',
            $row->varianObat->obat->jenisObat->nama_jenis ?? '-',
            $row->varianObat->dosis_mg ?? 0,
            $row->no_batch ?? '-',
            $row->jumlah,
            (float) ($row->varianObat->harga ?? 0),
            (float) ($row->varianObat->harga ?? 0) * $row->jumlah,
            $row->tanggal_masuk->format('d/m/Y'),
            $row->tanggal_kadaluarsa->format('d/m/Y'),
            $row->sisa_hari,
            strtoupper($row->status_kadaluarsa),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,  'B' => 22, 'C' => 22, 'D' => 12,
            'E' => 10, 'F' => 16, 'G' => 12, 'H' => 18,
            'I' => 18, 'J' => 14, 'K' => 16, 'L' => 10,
            'M' => 12,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0B1F3A']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet   = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = 'M';

                // Border
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('D1D5DB');

                // Freeze header
                $sheet->freezePane('A2');

                // Warna baris + warna status
                $statusColor = [
                    'EXPIRED' => 'FEE2E2', 'KRITIS' => 'FEF3C7',
                    'WARNING' => 'DBEAFE', 'AMAN'   => 'D1FAE5',
                ];

                for ($i = 2; $i <= $lastRow; $i++) {
                    $statusVal = strtoupper($sheet->getCell("M{$i}")->getValue() ?? '');
                    $bg = $statusColor[$statusVal] ?? ($i % 2 === 0 ? 'F8F9FA' : 'FFFFFF');
                    $sheet->getStyle("A{$i}:{$lastCol}{$i}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($bg);
                }

                // Format angka
                foreach (['G', 'H', 'I'] as $col) {
                    $sheet->getStyle("{$col}2:{$col}{$lastRow}")->getNumberFormat()
                        ->setFormatCode('#,##0');
                }

                // Baris total
                $totalRow = $lastRow + 1;
                $sheet->setCellValue("F{$totalRow}", 'TOTAL STOK');
                $sheet->setCellValue("G{$totalRow}", "=SUM(G2:G{$lastRow})");
                $sheet->setCellValue("I{$totalRow}", "=SUM(I2:I{$lastRow})");
                $sheet->getStyle("A{$totalRow}:{$lastCol}{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C9A84C']],
                ]);
                $sheet->getStyle("G{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("I{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');

                // Judul
                $sheet->insertNewRowBefore(1, 3);
                $sheet->setCellValue('A1', 'REKAP STOK OBAT');
                $sheet->setCellValue('A2', 'Klinik Yos Benito');
                $sheet->setCellValue('A3', 'Dicetak: ' . now()->format('d/m/Y H:i'));

                foreach (['A1', 'A2', 'A3'] as $cell) {
                    $sheet->mergeCells("{$cell}:{$lastCol}" . substr($cell, 1));
                }

                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '0B1F3A']],
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

    public function title(): string { return 'Rekap Stok'; }
}
