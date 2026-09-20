<?php

namespace App\Http\Controllers;

use App\Exports\PemakaianObatExport;
use App\Exports\StokObatExport;
use App\Models\PemakaianObat;
use App\Models\StokObat;
use App\Models\JenisObat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    // ── Export Pemakaian Excel ────────────────────────────────────
    public function pemakaianExcel(Request $request)
    {
        $filename = 'laporan-pemakaian-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new PemakaianObatExport(
                dari:   $request->get('dari'),
                sampai: $request->get('sampai'),
                jenis:  $request->get('jenis'),
                cari:   $request->get('cari'),
            ),
            $filename
        );
    }

    // ── Export Pemakaian PDF ──────────────────────────────────────
    public function pemakaianPdf(Request $request)
    {
        $query = PemakaianObat::with(['varianObat.obat.jenisObat', 'stokObat'])
            ->orderBy('tanggal_pakai', 'desc');

        if ($request->filled('dari'))   $query->where('tanggal_pakai', '>=', $request->dari);
        if ($request->filled('sampai')) $query->where('tanggal_pakai', '<=', $request->sampai);
        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->whereHas('varianObat.obat.jenisObat', fn($q) =>
                $q->where('id_jenis', $request->jenis)
            );
        }

        $data     = $query->get();
        $total    = $data->sum('jumlah_pakai');
        $nilai    = $data->sum(fn($r) => ($r->varianObat->harga ?? 0) * $r->jumlah_pakai);
        $periode  = [
            'dari'   => $request->get('dari'),
            'sampai' => $request->get('sampai'),
        ];

        $pdf = Pdf::loadView('pdf.laporan-pemakaian', compact('data', 'total', 'nilai', 'periode'))
                  ->setPaper('a4', 'landscape');

        $filename = 'laporan-pemakaian-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    // ── Export Stok Excel ─────────────────────────────────────────
    public function stokExcel(Request $request)
    {
        $filename = 'rekap-stok-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new StokObatExport(
                jenis:  $request->get('jenis'),
                status: $request->get('status'),
                cari:   $request->get('cari'),
            ),
            $filename
        );
    }

    // ── Export Stok PDF ───────────────────────────────────────────
    public function stokPdf(Request $request)
    {
        $query = StokObat::with(['varianObat.obat.jenisObat'])
            ->orderBy('tanggal_kadaluarsa');

        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->whereHas('varianObat.obat.jenisObat', fn($q) =>
                $q->where('id_jenis', $request->jenis)
            );
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            match ($request->status) {
                'expired'  => $query->expired(),
                'kritis'   => $query->mendekatiKadaluarsa(30),
                'ada_stok' => $query->adaStok(),
                'habis'    => $query->where('jumlah', 0),
                default    => null,
            };
        }

        $data       = $query->get();
        $totalStok  = $data->sum('jumlah');
        $totalNilai = $data->sum(fn($r) => ($r->varianObat->harga ?? 0) * $r->jumlah);

        $pdf = Pdf::loadView('pdf.rekap-stok', compact('data', 'totalStok', 'totalNilai'))
                  ->setPaper('a4', 'landscape');

        $filename = 'rekap-stok-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}
