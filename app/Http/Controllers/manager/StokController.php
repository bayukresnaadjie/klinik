<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $today    = Carbon::today()->toDateString();
        $bulanIni = Carbon::now()->startOfMonth()->toDateString();

        // ── Summary Strip ─────────────────────────────────────────
        $totalJenis = DB::table('varian_obat')->count();
        $totalUnit  = DB::table('stok_obat')->sum('jumlah');

        // Stok rendah: jumlah <= stok_minimum di varian_obat
        $stokRendah = DB::table('stok_obat as s')
            ->join('varian_obat as v', 'v.id_varian', '=', 's.id_varian')
            ->where('s.jumlah', '>', 0)
            ->whereColumn('s.jumlah', '<=', 'v.stok_minimum')
            ->count();

        // Mendekati expired <= 30 hari
        $mendekatiExp = DB::table('stok_obat')
            ->whereNotNull('tanggal_kadaluarsa')
            ->where('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(30)->toDateString())
            ->where('jumlah', '>', 0)
            ->count();

        // ── Jenis obat untuk dropdown ─────────────────────────────
        $jenisObat = DB::table('jenis_obat')->pluck('nama_jenis');

        // ── Query Stok ────────────────────────────────────────────
        $query = DB::table('stok_obat as s')
            ->join('varian_obat as v',  'v.id_varian', '=', 's.id_varian')
            ->join('obat as o',         'o.id_obat',   '=', 'v.id_obat')
            ->join('jenis_obat as j',   'j.id_jenis',  '=', 'o.id_jenis')
            ->select(
                's.id_stok',
                's.id_varian',
                's.jumlah',
                's.no_batch',
                's.tanggal_kadaluarsa',
                's.tanggal_masuk',
                'v.stok_minimum',
                'v.nama_merek',
                'v.dosis_mg',
                'o.nama_obat',
                'j.nama_jenis as jenis'
            );

        // Filter jenis
        if ($jenis = $request->get('jenis')) {
            $query->where('j.nama_jenis', $jenis);
        }

        // Filter status
        if ($status = $request->get('status')) {
            $query = match ($status) {
                'aman'   => $query->whereRaw('s.jumlah > v.stok_minimum * 2'),
                'rendah' => $query->whereRaw('s.jumlah > v.stok_minimum AND s.jumlah <= v.stok_minimum * 2'),
                'kritis' => $query->whereRaw('s.jumlah > 0 AND s.jumlah <= v.stok_minimum'),
                'exp'    => $query->whereNotNull('s.tanggal_kadaluarsa')
                                  ->where('s.tanggal_kadaluarsa', '<=', Carbon::now()->addDays(30)->toDateString()),
                default  => $query,
            };
        }

        // Filter search
        if ($q = $request->get('q')) {
            $query->where(function ($qb) use ($q) {
                $qb->where('o.nama_obat',  'like', "%{$q}%")
                   ->orWhere('v.nama_merek','like', "%{$q}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'nama');
        $query = match ($sort) {
            'stok_asc'  => $query->orderBy('s.jumlah', 'asc'),
            'stok_desc' => $query->orderBy('s.jumlah', 'desc'),
            'exp'       => $query->orderBy('s.tanggal_kadaluarsa', 'asc'),
            default     => $query->orderBy('o.nama_obat', 'asc'),
        };

        // Paginate manual karena pakai DB::table
        $perPage     = 20;
        $currentPage = $request->get('page', 1);
        $total       = (clone $query)->count();
        $items       = $query->offset(($currentPage - 1) * $perPage)->limit($perPage)->get();

        // Hitung stok_maks dari pemakaian bulan ini
        $items = $items->map(function ($item) use ($bulanIni, $today) {
            $pemakaianBulanIni = DB::table('pemakaian_obat')
                ->where('id_varian', $item->id_varian)
                ->whereBetween('tanggal_pakai', [$bulanIni, $today])
                ->sum('jumlah_pakai');

            $item->stok_maks = max($item->jumlah + $pemakaianBulanIni, 1);
            return $item;
        });

        // Buat paginator manual
        $stokList = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $notifCount = $stokRendah + $mendekatiExp;

        return view('manager.stok', compact(
            'totalJenis',
            'totalUnit',
            'stokRendah',
            'mendekatiExp',
            'jenisObat',
            'stokList',
            'notifCount',
        ));
    }
}
