<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrenController extends Controller
{
    public function index(Request $request)
    {
        $rentang  = (int) $request->get('rentang', 6);
        $jenis    = $request->get('jenis');
        $varianId = $request->get('obat_id'); // obat_id di form = id_varian

        $mulai      = Carbon::now()->subMonths($rentang - 1)->startOfMonth()->toDateString();
        $sebelumnya = Carbon::now()->subMonths(($rentang * 2) - 1)->startOfMonth()->toDateString();

        // ── Dropdown ──────────────────────────────────────────────
        $jenisObat  = DB::table('jenis_obat')->pluck('nama_jenis');
        $daftarObat = DB::table('varian_obat as v')
            ->join('obat as o',       'o.id_obat',  '=', 'v.id_obat')
            ->join('jenis_obat as j', 'j.id_jenis', '=', 'o.id_jenis')
            ->select('v.id_varian as id', DB::raw("CONCAT(o.nama_obat,' ',v.nama_merek,' ',v.dosis_mg,'mg') as nama"), 'j.nama_jenis as jenis')
            ->orderBy('o.nama_obat')
            ->get();

        // ── Tren Bulanan ──────────────────────────────────────────
        $queryTren = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v',  'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->selectRaw("DATE_FORMAT(p.tanggal_pakai, '%Y-%m') as ym, SUM(p.jumlah_pakai) as total")
            ->where('p.tanggal_pakai', '>=', $mulai)
            ->when($jenis,    fn($q) => $q->where('j.nama_jenis', $jenis))
            ->when($varianId, fn($q) => $q->where('p.id_varian', $varianId))
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        // Isi bulan kosong
        $trendBulanan = collect();
        for ($i = 0; $i < $rentang; $i++) {
            $bulan = Carbon::now()->subMonths($rentang - 1 - $i)->startOfMonth();
            $ym    = $bulan->format('Y-m');
            $trendBulanan->push((object) [
                'ym'    => $ym,
                'label' => $bulan->translatedFormat('M Y'),
                'total' => $queryTren->get($ym)?->total ?? 0,
            ]);
        }

        // ── Summary ───────────────────────────────────────────────
        $totalPeriode = $trendBulanan->sum('total');
        $rataPerBulan = $rentang > 0 ? round($totalPeriode / $rentang) : 0;

        $tertinggi      = $trendBulanan->sortByDesc('total')->first();
        $bulanTertinggi = $tertinggi?->label ?? '-';
        $nilaiTertinggi = $tertinggi?->total ?? 0;

        $totalSebelumnya = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v',  'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->whereBetween('p.tanggal_pakai', [$sebelumnya, $mulai])
            ->when($jenis,    fn($q) => $q->where('j.nama_jenis', $jenis))
            ->when($varianId, fn($q) => $q->where('p.id_varian', $varianId))
            ->sum('p.jumlah_pakai');

        $trendPct = $totalSebelumnya > 0
            ? round((($totalPeriode - $totalSebelumnya) / $totalSebelumnya) * 100)
            : 0;

        $summary = (object) [
            'total'           => $totalPeriode,
            'trend'           => $trendPct,
            'rata_bulan'      => $rataPerBulan,
            'bulan_tertinggi' => $bulanTertinggi,
            'nilai_tertinggi' => $nilaiTertinggi,
        ];

        // ── Heatmap Harian Bulan Ini ──────────────────────────────
        $heatmapData = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v',  'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->selectRaw('DAY(p.tanggal_pakai) as hari, SUM(p.jumlah_pakai) as total')
            ->whereYear('p.tanggal_pakai',  now()->year)
            ->whereMonth('p.tanggal_pakai', now()->month)
            ->when($jenis,    fn($q) => $q->where('j.nama_jenis', $jenis))
            ->when($varianId, fn($q) => $q->where('p.id_varian', $varianId))
            ->groupBy('hari')
            ->pluck('total', 'hari');

        // ── Top Obat Minggu Ini ───────────────────────────────────
        $topMingguIni = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v',  'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->selectRaw("
                CONCAT(o.nama_obat, ' ', v.nama_merek, ' ', v.dosis_mg, 'mg') as nama_obat,
                j.nama_jenis as jenis,
                SUM(p.jumlah_pakai) as total
            ")
            ->whereBetween('p.tanggal_pakai', [
                Carbon::now()->startOfWeek()->toDateString(),
                Carbon::now()->endOfWeek()->toDateString(),
            ])
            ->when($jenis,    fn($q) => $q->where('j.nama_jenis', $jenis))
            ->when($varianId, fn($q) => $q->where('p.id_varian', $varianId))
            ->groupBy('v.id_varian', 'o.nama_obat', 'v.nama_merek', 'v.dosis_mg', 'j.nama_jenis')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        $notifCount = 0;

        return view('manager.tren', compact(
            'jenisObat',
            'daftarObat',
            'trendBulanan',
            'summary',
            'heatmapData',
            'topMingguIni',
            'notifCount',
        ));
    }
}
