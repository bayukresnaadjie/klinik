<?php

namespace App\Http\Controllers;

use App\Models\PemakaianObat;
use App\Models\StokObat;
use App\Models\VarianObat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // ── Halaman utama laporan ─────────────────────────────────────
   public function index()
{
    $bulanIni = now()->month;
    $tahunIni = now()->year;

    // ── Summary cards ──────────────────────────────────────
    $totalVarian = VarianObat::count();

    $pemakaianBulanIni = PemakaianObat::whereMonth('tanggal_pakai', $bulanIni)
                            ->whereYear('tanggal_pakai', $tahunIni)
                            ->sum('jumlah_pakai');

   $bawahMinimum = VarianObat::where('alert_minimum', true)
                    ->where('stok_minimum', '>', 0)
                    ->get()
                    ->filter(function ($v) {
                        $totalStok = $v->stokObat->where('jumlah', '>', 0)->sum('jumlah');
                        return $totalStok <= $v->stok_minimum;
                    })->count();

    $akanExpired = StokObat::where('jumlah', '>', 0)
                    ->whereBetween('tanggal_kadaluarsa', [now(), now()->addDays(30)])
                    ->count();

    // ── Status Stok sidebar ────────────────────────────────
    $stokHabis    = StokObat::where('jumlah', 0)->count();
    $stokExpired  = StokObat::where('jumlah', '>', 0)
                        ->where('tanggal_kadaluarsa', '<', now())
                        ->count();

    // ── Ringkasan bulan ini ────────────────────────────────
    $pemakaianBulan = PemakaianObat::with('varianObat')
                        ->whereMonth('tanggal_pakai', $bulanIni)
                        ->whereYear('tanggal_pakai', $tahunIni)
                        ->get();

    $nilaiPemakaian = $pemakaianBulan->sum(
        fn($p) => $p->jumlah_pakai * (float) ($p->varianObat->harga ?? 0)
    );

    $jenisDipakai = $pemakaianBulan->pluck('id_varian')->unique()->count();

    $nilaiInventori = VarianObat::with(['stokObat' => fn($q) => $q->where('jumlah', '>', 0)])
                        ->get()
                        ->sum(fn($v) => $v->stokObat->sum('jumlah') * (float) ($v->harga ?? 0));

    $totalStok = StokObat::where('jumlah', '>', 0)->sum('jumlah');

    return view('laporan.index', compact(
        'totalVarian',
        'pemakaianBulanIni',
        'bawahMinimum',
        'akanExpired',
        'stokHabis',
        'stokExpired',
        'nilaiPemakaian',
        'jenisDipakai',
        'nilaiInventori',
        'totalStok',
        'pemakaianBulan',
    ));
}

    // ── Laporan Pemakaian Per Periode ─────────────────────────────
    public function pemakaian(Request $request)
    {
        $dari   = $request->get('dari',   now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', now()->toDateString());

        $pemakaian = PemakaianObat::with(['varianObat.obat.jenisObat'])
            ->whereBetween('tanggal_pakai', [$dari, $sampai])
            ->get()
            ->groupBy('id_varian')
            ->map(function ($rows) {
                $varian = $rows->first()->varianObat;
                return [
                    'nama_merek'  => $varian->nama_merek ?? '-',
                    'nama_obat'   => $varian->obat->nama_obat ?? '-',
                    'jenis'       => $varian->obat->jenisObat->nama_jenis ?? '-',
                    'dosis_mg'    => $varian->dosis_mg ?? 0,
                    'harga'       => (float) ($varian->harga ?? 0),
                    'total_pakai' => $rows->sum('jumlah_pakai'),
                    'total_nilai' => (float) ($varian->harga ?? 0) * $rows->sum('jumlah_pakai'),
                    'last_pakai'  => $rows->max('tanggal_pakai'),
                ];
            })
            ->sortByDesc('total_pakai')
            ->values();

        $totalItem   = $pemakaian->sum('total_pakai');
        $totalNilai  = $pemakaian->sum('total_nilai');
        $jumlahJenis = $pemakaian->count();
        $topObat     = $pemakaian->take(5)->values();

        $rekapBulan = PemakaianObat::whereYear('tanggal_pakai', now()->year)
            ->select(
                DB::raw('MONTH(tanggal_pakai) as bulan'),
                DB::raw('SUM(jumlah_pakai) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $trenHarian = PemakaianObat::whereBetween('tanggal_pakai', [$dari, $sampai])
            ->select(
                DB::raw('DATE(tanggal_pakai) as tanggal'),
                DB::raw('SUM(jumlah_pakai) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->map(fn($r) => [
                'tanggal' => Carbon::parse($r->tanggal)->format('d/m'),
                'total'   => (int) $r->total,
            ]);

        $ringkasan = [
            'total_item'    => $totalItem,
            'total_nilai'   => $totalNilai,
            'jumlah_varian' => $jumlahJenis,
        ];

        return view('laporan.pemakaian', compact(
            'pemakaian',
            'ringkasan',
            'trenHarian',
            'topObat',
            'rekapBulan',
            'totalItem',
            'totalNilai',
            'jumlahJenis',
            'dari',
            'sampai',
        ));
    }

    // ── Rekap Stok ────────────────────────────────────────────────
    public function stok(Request $request)
    {
        $filterJenis  = $request->get('jenis',  'semua');
        $filterStatus = $request->get('status', 'semua');

        $query = VarianObat::with(['obat.jenisObat', 'stokObat'])
            ->when($filterJenis !== 'semua', function ($q) use ($filterJenis) {
                $q->whereHas('obat.jenisObat', fn($j) => $j->where('id_jenis', $filterJenis));
            });

        $varian = $query->get()->map(function ($v) {
            $stokAktif   = $v->stokObat->where('jumlah', '>', 0);
            $totalStok   = $stokAktif->sum('jumlah');
            $expTerdekat = $stokAktif->sortBy('tanggal_kadaluarsa')->first();

            $status = 'aman';
            if ($totalStok === 0) {
                $status = 'habis';
            } elseif ($expTerdekat && $expTerdekat->tanggal_kadaluarsa->isPast()) {
                $status = 'expired';
            } elseif ($expTerdekat && $expTerdekat->tanggal_kadaluarsa->diffInDays(now()) <= 30) {
                $status = 'kritis';
            } elseif ($v->alert_minimum && $v->stok_minimum > 0 && $totalStok <= $v->stok_minimum) {
                $status = 'minimum';
            }

            return [
                'nama_merek'   => $v->nama_merek,
                'nama_obat'    => $v->obat->nama_obat ?? '-',
                'jenis'        => $v->obat->jenisObat->nama_jenis ?? '-',
                'dosis_mg'     => $v->dosis_mg,
                'harga'        => (float) $v->harga,
                'total_stok'   => $totalStok,
                'jumlah_batch' => $stokAktif->count(),
                'exp_terdekat' => $expTerdekat?->tanggal_kadaluarsa->format('d/m/Y') ?? '-',
                'nilai_stok'   => (float) $v->harga * $totalStok,
                'stok_minimum' => $v->stok_minimum ?? 0,
                'status'       => $status,
            ];
        });

        if ($filterStatus !== 'semua') {
            $varian = $varian->filter(fn($v) => $v['status'] === $filterStatus);
        }

        $varian         = $varian->sortByDesc('total_stok')->values();
        $totalVarian    = $varian->count();
        $totalStok      = $varian->sum('total_stok');
        $nilaiInventori = $varian->sum('nilai_stok');
        $stokHabis      = $varian->where('status', 'habis')->count();
        $stokKritis     = $varian->where('status', 'kritis')->count();
        $sudahExpired   = $varian->where('status', 'expired')->count();

        $distribStatus = [
            'aman'    => $varian->where('status', 'aman')->count(),
            'minimum' => $varian->where('status', 'minimum')->count(),
            'kritis'  => $varian->where('status', 'kritis')->count(),
            'expired' => $varian->where('status', 'expired')->count(),
            'habis'   => $varian->where('status', 'habis')->count(),
        ];

        $stokPerJenis = $varian->groupBy('jenis')
            ->map(fn($g, $nama) => [
                'nama'       => $nama,
                'total_stok' => $g->sum('total_stok'),
            ])
            ->sortByDesc('total_stok')
            ->values();

        $jenisObatList = \App\Models\JenisObat::orderBy('nama_jenis')->get();

        $ringkasan = [
            'total_varian' => $totalVarian,
            'total_stok'   => $totalStok,
            'total_nilai'  => $nilaiInventori,
            'stok_habis'   => $stokHabis,
            'stok_kritis'  => $stokKritis,
            'stok_expired' => $sudahExpired,
        ];

        return view('laporan.stok', compact(
            'varian',
            'ringkasan',
            'stokPerJenis',
            'distribStatus',
            'jenisObatList',
            'filterJenis',
            'filterStatus',
            'totalVarian',
            'totalStok',
            'nilaiInventori',
            'stokHabis',
            'stokKritis',
            'sudahExpired',
        ));
    }

    // ── Tren Pemakaian Bulanan ─────────────────────────────────────
    public function tren(Request $request)
    {
        $tahun = (int) $request->get('tahun', now()->year);

        $rekapBulan = PemakaianObat::with('varianObat')
            ->whereYear('tanggal_pakai', $tahun)
            ->get()
            ->groupBy(fn($p) => (int) Carbon::parse($p->tanggal_pakai)->format('n'))
            ->map(function ($rows, $bulan) {
                $nilai = $rows->sum(
                    fn($p) => $p->jumlah_pakai * (float) ($p->varianObat->harga ?? 0)
                );
                return (object) [
                    'bulan' => $bulan,
                    'total' => $rows->sum('jumlah_pakai'),
                    'nilai' => $nilai,
                ];
            })
            ->sortKeys()
            ->values();

        $chartPakai = array_fill(0, 12, 0);
        $chartNilai = array_fill(0, 12, 0);
        foreach ($rekapBulan as $rb) {
            $chartPakai[$rb->bulan - 1] = (int) $rb->total;
            $chartNilai[$rb->bulan - 1] = (float) $rb->nilai;
        }

        $totalPakai     = array_sum($chartPakai);
        $totalNilai     = array_sum($chartNilai);
        $rataRata       = $rekapBulan->count() > 0 ? round($totalPakai / $rekapBulan->count()) : 0;
        $bulanNames     = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $maxIdx         = array_search(max($chartPakai), $chartPakai);
        $bulanTertinggi = $totalPakai > 0 ? $bulanNames[$maxIdx] : '—';

        $topObat = PemakaianObat::with(['varianObat.obat'])
            ->whereYear('tanggal_pakai', $tahun)
            ->get()
            ->groupBy('id_varian')
            ->map(function ($rows) {
                $varian        = $rows->first()->varianObat;
                $obatObj       = new \stdClass();
                $obatObj->nama = $varian->obat->nama_obat ?? '-';
                $item              = new \stdClass();
                $item->nama        = $varian->nama_merek ?? '-';
                $item->obat        = $obatObj;
                $item->total_pakai = (int) $rows->sum('jumlah_pakai');
                return $item;
            })
            ->sortByDesc('total_pakai')
            ->take(7)
            ->values();

        return view('laporan.tren', compact(
            'rekapBulan',
            'chartPakai',
            'chartNilai',
            'totalPakai',
            'totalNilai',
            'rataRata',
            'bulanTertinggi',
            'topObat',
            'tahun',
        ));
    }
}
