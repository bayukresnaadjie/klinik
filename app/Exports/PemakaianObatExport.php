<?php

namespace App\Exports;

use App\Models\PemakaianObat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class PemakaianObatExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnWidths,
    WithEvents
{
    public function __construct(
        protected ?string $dari   = null,
        protected ?string $sampai = null,
        protected ?string $jenis  = null,
        protected ?string $cari   = null,
    ) {}

    public function query()
    {
        $query = PemakaianObat::with(['varianObat.obat.jenisObat', 'stokObat'])
            ->orderBy('tanggal_pakai', 'desc');

        if ($this->dari)   $query->where('tanggal_pakai', '>=', $this->dari);
        if ($this->sampai) $query->where('tanggal_pakai', '<=', $this->sampai);

        if ($this->jenis && $this->jenis !== 'semua') {
            $query->whereHas('varianObat.obat.jenisObat', fn($q) =>
                $q->where('id_jenis', $this->jenis)
            );
        }

        if ($this->cari) {
            $cari = $this->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('keterangan', 'like', "%{$cari}%")
                  ->orWhereHas('varianObat', fn($q2) =>
                      $q2->where('nama_merek', 'like', "%{$cari}%")
                  );
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pakai',
            'Nama Merek',
            'Zat Aktif',
            'Jenis',
            'Dosis (mg)',
            'No. Batch',
            'Jumlah Pakai',
            'Harga Satuan (Rp)',
            'Total Nilai (Rp)',
            'Keterangan',
        ];
    }

    protected int $row = 1;

    public function map($row): array
    {
        return [
            $this->row++,
            $row->tanggal_pakai->format('d/m/Y'),
            $row->varianObat->nama_merek ?? '-',
            $row->varianObat->obat->nama_obat ?? '-',
            $row->varianObat->obat->jenisObat->nama_jenis ?? '-',
            $row->varianObat->dosis_mg ?? 0,
            $row->stokObat->no_batch ?? '-',
            $row->jumlah_pakai,
            (float) ($row->varianObat->harga ?? 0),
            (float) ($row->varianObat->harga ?? 0) * $row->jumlah_pakai,
            $row->keterangan ?? '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 14,
            'C' => 20,
            'D' => 20,
            'E' => 12,
            'F' => 10,
            'G' => 16,
            'H' => 14,
            'I' => 18,
            'J' => 18,
            'K' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row
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
                $sheet      = $event->sheet->getDelegate();
                $lastRow    = $sheet->getHighestRow();
                $lastCol    = 'K';
                $dataRange  = "A1:{$lastCol}{$lastRow}";

                // Border semua sel
                $sheet->getStyle($dataRange)->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setRGB('D1D5DB');

                // Freeze header
                $sheet->freezePane('A2');

                // Warna baris selang-seling
                for ($i = 2; $i <= $lastRow; $i++) {
                    if ($i % 2 === 0) {
                        $sheet->getStyle("A{$i}:{$lastCol}{$i}")
                            ->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F8F9FA');
                    }
                }

                // Format angka kolom H, I, J
                $sheet->getStyle("H2:H{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("I2:I{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("J2:J{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');

                // Baris total di bawah
                $totalRow = $lastRow + 1;
                $sheet->setCellValue("G{$totalRow}", 'TOTAL');
                $sheet->setCellValue("H{$totalRow}", "=SUM(H2:H{$lastRow})");
                $sheet->setCellValue("J{$totalRow}", "=SUM(J2:J{$lastRow})");

                $sheet->getStyle("A{$totalRow}:{$lastCol}{$totalRow}")
                    ->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C9A84C']],
                    ]);

                $sheet->getStyle("H{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("J{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');

                // Judul di atas header
                $sheet->insertNewRowBefore(1, 3);
                $sheet->setCellValue('A1', 'LAPORAN PEMAKAIAN OBAT');
                $sheet->setCellValue('A2', 'Klinik Yos Benito');
                $periodeText = ($this->dari && $this->sampai)
                    ? 'Periode: ' . date('d/m/Y', strtotime($this->dari)) . ' — ' . date('d/m/Y', strtotime($this->sampai))
                    : 'Periode: Semua';
                $sheet->setCellValue('A3', $periodeText . ' | Dicetak: ' . now()->format('d/m/Y H:i'));

                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->mergeCells("A3:{$lastCol}3");

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

    public function title(): string
    {
        return 'Laporan Pemakaian';
    }
}
