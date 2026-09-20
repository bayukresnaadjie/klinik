<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeringatanController extends Controller
{
    public function index(Request $request)
    {
        $today         = Carbon::today()->toDateString();
        $bulanIni      = Carbon::now()->startOfMonth()->toDateString();
        $tigaBulanLalu = Carbon::now()->subMonths(3)->startOfMonth()->toDateString();

        // ── Stok Kritis & Habis ───────────────────────────────────
        $stokKritis = DB::table('stok_obat as s')
            ->join('varian_obat as v',  'v.id_varian', '=', 's.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->select(
                's.id_stok',
                's.jumlah',
                'v.stok_minimum',
                'v.nama_merek',
                'v.dosis_mg',
                'o.nama_obat',
                'j.nama_jenis as jenis'
            )
            ->where(function ($q) {
                $q->where('s.jumlah', '<=', 0)
                  ->orWhereColumn('s.jumlah', '<=', 'v.stok_minimum');
            })
            ->orderBy('s.jumlah')
            ->get();

        // ── Mendekati Expired (≤ 90 hari) ────────────────────────
        $mendekatiExp = DB::table('stok_obat as s')
            ->join('varian_obat as v',  'v.id_varian', '=', 's.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->select(
                's.id_stok',
                's.jumlah',
                's.no_batch',
                's.tanggal_kadaluarsa',
                'v.nama_merek',
                'v.dosis_mg',
                'o.nama_obat',
                'j.nama_jenis as jenis'
            )
            ->whereNotNull('s.tanggal_kadaluarsa')
            ->where('s.tanggal_kadaluarsa', '>', $today)
            ->where('s.tanggal_kadaluarsa', '<=', Carbon::now()->addDays(90)->toDateString())
            ->where('s.jumlah', '>', 0)
            ->orderBy('s.tanggal_kadaluarsa')
            ->get();

        // ── Sudah Expired ─────────────────────────────────────────
        $sudahExp = DB::table('stok_obat as s')
            ->join('varian_obat as v',  'v.id_varian', '=', 's.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->select(
                's.id_stok',
                's.jumlah',
                's.no_batch',
                's.tanggal_kadaluarsa',
                'v.nama_merek',
                'v.dosis_mg',
                'o.nama_obat',
                'j.nama_jenis as jenis'
            )
            ->whereNotNull('s.tanggal_kadaluarsa')
            ->where('s.tanggal_kadaluarsa', '<=', $today)
            ->where('s.jumlah', '>', 0)
            ->orderBy('s.tanggal_kadaluarsa')
            ->get();

        // ── Anomali Pemakaian ─────────────────────────────────────
        // Pemakaian bulan ini per varian
        $pemakaianBulanIni = DB::table('pemakaian_obat')
            ->selectRaw('id_varian, SUM(jumlah_pakai) as total')
            ->whereBetween('tanggal_pakai', [$bulanIni, $today])
            ->groupBy('id_varian')
            ->get()
            ->keyBy('id_varian');

        // Rata-rata 3 bulan sebelumnya per varian
        $rataRata3Bulan = DB::table(
            DB::table('pemakaian_obat')
                ->selectRaw("id_varian, DATE_FORMAT(tanggal_pakai, '%Y-%m') as ym, SUM(jumlah_pakai) as monthly_total")
                ->whereBetween('tanggal_pakai', [$tigaBulanLalu, $bulanIni])
                ->groupBy('id_varian', 'ym'),
            'monthly'
        )
        ->selectRaw('id_varian, AVG(monthly_total) as rata')
        ->groupBy('id_varian')
        ->get()
        ->keyBy('id_varian');

        $anomali = collect();
        foreach ($pemakaianBulanIni as $varianId => $row) {
            $rata = $rataRata3Bulan->get($varianId)?->rata ?? 0;
            if ($rata > 0 && $row->total >= ($rata * 2)) {
                $varian = DB::table('varian_obat as v')
                    ->join('obat as o',       'o.id_obat',  '=', 'v.id_obat')
                    ->join('jenis_obat as j', 'j.id_jenis', '=', 'o.id_jenis')
                    ->where('v.id_varian', $varianId)
                    ->select('o.nama_obat', 'v.nama_merek', 'v.dosis_mg', 'j.nama_jenis as jenis')
                    ->first();

                if (!$varian) continue;

                $anomali->push((object) [
                    'obat_id'     => $varianId,
                    'nama_obat'   => $varian->nama_obat . ' ' . $varian->nama_merek . ' ' . $varian->dosis_mg . 'mg',
                    'jenis'       => $varian->jenis,
                    'bulan_ini'   => $row->total,
                    'rata_rata'   => round($rata),
                    'persen_naik' => round((($row->total - $rata) / $rata) * 100),
                ]);
            }
        }
        $anomali = $anomali->sortByDesc('persen_naik')->values();

        // ── Counts ────────────────────────────────────────────────
        $counts = [
            'kritis'    => $stokKritis->count(),
            'exp'       => $mendekatiExp->count(),
            'sudah_exp' => $sudahExp->count(),
            'anomali'   => $anomali->count(),
        ];

        $notifCount = $counts['kritis'] + $counts['sudah_exp'] + $counts['exp'];

        return view('manager.peringatan', compact(
            'stokKritis',
            'mendekatiExp',
            'sudahExp',
            'anomali',
            'counts',
            'notifCount',
        ));
    }
}
