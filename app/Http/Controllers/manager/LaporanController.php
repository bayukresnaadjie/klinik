<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\PemakaianObat;
use App\Models\StokObat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $filterBulan = (int) $request->get('bulan', now()->month);
        $filterTahun = (int) $request->get('tahun', now()->year);
        $filterJenis = $request->get('jenis');

        $periodeAwal      = Carbon::create($filterTahun, $filterBulan, 1)->startOfMonth()->toDateString();
        $periodeAkhir     = Carbon::create($filterTahun, $filterBulan, 1)->endOfMonth()->toDateString();
        $periodeAwalLalu  = Carbon::create($filterTahun, $filterBulan, 1)->subMonth()->startOfMonth()->toDateString();
        $periodeAkhirLalu = Carbon::create($filterTahun, $filterBulan, 1)->subMonth()->endOfMonth()->toDateString();

        // ── Jenis obat untuk filter dropdown ─────────────────────
        $jenisObat = DB::table('jenis_obat')->pluck('nama_jenis');

        // ── Base query pemakaian dengan join ──────────────────────
        $baseQuery = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v',  'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->whereBetween('p.tanggal_pakai', [$periodeAwal, $periodeAkhir]);

        if ($filterJenis) {
            $baseQuery->where('j.nama_jenis', $filterJenis);
        }

        // ── Summary KPI ───────────────────────────────────────────
        $totalPemakaian = (clone $baseQuery)->sum('p.jumlah_pakai');

        $totalPemakaianLalu = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v', 'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',  'j.id_jenis',  '=', 'o.id_jenis')
            ->whereBetween('p.tanggal_pakai', [$periodeAwalLalu, $periodeAkhirLalu])
            ->when($filterJenis, fn($q) => $q->where('j.nama_jenis', $filterJenis))
            ->sum('p.jumlah_pakai');

        $pemakaianTrend = $totalPemakaianLalu > 0
            ? round((($totalPemakaian - $totalPemakaianLalu) / $totalPemakaianLalu) * 100)
            : 0;

        $variasiObat   = (clone $baseQuery)->distinct('p.id_varian')->count('p.id_varian');
        $totalVarian   = DB::table('varian_obat')->count();
        $efisiensi     = $totalVarian > 0 ? round(($variasiObat / $totalVarian) * 100) : 0;

        $variasiLalu = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v', 'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',  'j.id_jenis',  '=', 'o.id_jenis')
            ->whereBetween('p.tanggal_pakai', [$periodeAwalLalu, $periodeAkhirLalu])
            ->when($filterJenis, fn($q) => $q->where('j.nama_jenis', $filterJenis))
            ->distinct('p.id_varian')->count('p.id_varian');

        $efisiensiLalu  = $totalVarian > 0 ? round(($variasiLalu / $totalVarian) * 100) : 0;
        $efisiensiTrend = $efisiensi - $efisiensiLalu;

        $stokKritis = DB::table('stok_obat as s')
            ->join('varian_obat as v', 'v.id_varian', '=', 's.id_varian')
            ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',  'j.id_jenis',  '=', 'o.id_jenis')
            ->where('s.jumlah', '>', 0)
            ->whereColumn('s.jumlah', '<=', 'v.stok_minimum')
            ->when($filterJenis, fn($q) => $q->where('j.nama_jenis', $filterJenis))
            ->count();

        $summary = (object) [
            'total_pemakaian' => $totalPemakaian,
            'pemakaian_trend' => $pemakaianTrend,
            'variasi_obat'    => $variasiObat,
            'efisiensi'       => $efisiensi,
            'efisiensi_trend' => $efisiensiTrend,
            'stok_kritis'     => $stokKritis,
        ];

        // ── Tren Bulanan 12 bulan ─────────────────────────────────
        $trendRaw = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v', 'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',  'j.id_jenis',  '=', 'o.id_jenis')
            ->selectRaw('MONTH(p.tanggal_pakai) as bulan, SUM(p.jumlah_pakai) as total')
            ->whereYear('p.tanggal_pakai', $filterTahun)
            ->when($filterJenis, fn($q) => $q->where('j.nama_jenis', $filterJenis))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $trendBulanan = collect(range(1, 12))->map(fn($m) => (object)[
            'bulan' => $m,
            'total' => $trendRaw->get($m)?->total ?? 0,
        ]);

        // ── Distribusi Jenis Obat ─────────────────────────────────
        $distribusiJenis = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v', 'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',  'j.id_jenis',  '=', 'o.id_jenis')
            ->selectRaw('j.nama_jenis as jenis, SUM(p.jumlah_pakai) as total')
            ->whereBetween('p.tanggal_pakai', [$periodeAwal, $periodeAkhir])
            ->when($filterJenis, fn($q) => $q->where('j.nama_jenis', $filterJenis))
            ->groupBy('j.nama_jenis', 'j.id_jenis')
            ->orderByDesc('total')
            ->get();

        // ── Top 10 Obat ───────────────────────────────────────────
        $topObat = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v', 'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',  'j.id_jenis',  '=', 'o.id_jenis')
            ->selectRaw('
                v.id_varian,
                o.nama_obat,
                v.nama_merek as dosis,
                v.dosis_mg,
                j.nama_jenis as jenis,
                SUM(p.jumlah_pakai) as total
            ')
            ->whereBetween('p.tanggal_pakai', [$periodeAwal, $periodeAkhir])
            ->when($filterJenis, fn($q) => $q->where('j.nama_jenis', $filterJenis))
            ->groupBy('v.id_varian', 'o.nama_obat', 'v.nama_merek', 'v.dosis_mg', 'j.nama_jenis')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(function ($obat) {
                $stokSisa        = StokObat::where('id_varian', $obat->id_varian)->sum('jumlah');
                $obat->stok_sisa = $stokSisa;
                $obat->stok_maks = $stokSisa + $obat->total;
                return $obat;
            });

        $notifCount = $summary->stok_kritis;

        return view('manager.laporan', compact(
            'filterBulan', 'filterTahun', 'filterJenis',
            'jenisObat',
            'summary',
            'trendBulanan',
            'distribusiJenis',
            'topObat',
            'notifCount',
        ));
    }


   // ── Export Excel ──────────────────────────────────────────────
public function export(Request $request)
{
    $filterBulan = (int) $request->get('bulan', now()->month);
    $filterTahun = (int) $request->get('tahun', now()->year);
    $filterJenis = $request->get('jenis');

    $periodeAwal  = Carbon::create($filterTahun, $filterBulan, 1)->startOfMonth()->toDateString();
    $periodeAkhir = Carbon::create($filterTahun, $filterBulan, 1)->endOfMonth()->toDateString();

    $data = DB::table('pemakaian_obat as p')
        ->join('varian_obat as v', 'v.id_varian', '=', 'p.id_varian')
        ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
        ->join('jenis_obat as j',  'j.id_jenis',  '=', 'o.id_jenis')
        ->selectRaw('
            o.nama_obat,
            v.nama_merek,
            v.dosis_mg,
            j.nama_jenis as jenis,
            SUM(p.jumlah_pakai) as total,
            COUNT(p.id_pakai) as frekuensi
        ')
        ->whereBetween('p.tanggal_pakai', [$periodeAwal, $periodeAkhir])
        ->when($filterJenis, fn($q) => $q->where('j.nama_jenis', $filterJenis))
        ->groupBy('v.id_varian', 'o.nama_obat', 'v.nama_merek', 'v.dosis_mg', 'j.nama_jenis')
        ->orderByDesc('total')
        ->get();

    $periode = Carbon::create($filterTahun, $filterBulan)->translatedFormat('F Y');
    $filename = "laporan-kinerja-{$filterTahun}-{$filterBulan}.xlsx";

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\LaporanKinerjaExport($data, $periode),
        $filename
    );
}
}
