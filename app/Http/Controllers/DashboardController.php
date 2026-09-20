<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ApprovalRequest;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Redirect sesuai role ─────────────────────────────────
        $user = auth()->user();

        if ($user->role === 'manajer') {
            return redirect()->route('manager.dashboard');
        }

        if ($user->role === 'kasir') {
            return redirect()->route('kasir.dashboard');
        }
        // ────────────────────────────────────────────────────────

        $now   = Carbon::now();
        $limit = $now->copy()->addDays(30);

        /* =======================
         * 1. STAT CARDS
         * ======================= */

        // Total variasi obat
        $totalVariasiObat = DB::table('varian_obat')->count();

        // Total stok (belum expired)
        $totalStok = DB::table('stok_obat')
            ->where('tanggal_kadaluarsa', '>', $now)
            ->sum('jumlah');

        // Batch expired
        $sudahExpire = DB::table('stok_obat')
            ->where('tanggal_kadaluarsa', '<=', $now)
            ->where('jumlah', '>', 0)
            ->count();

        // Batch mendekati expired
        $mendekatiExpQuery = DB::table('stok_obat')
            ->where('tanggal_kadaluarsa', '>', $now)
            ->where('tanggal_kadaluarsa', '<=', $limit)
            ->where('jumlah', '>', 0);

        $mendekatiExp = $mendekatiExpQuery->count();

        /* =======================
         * 2. ALERT STOK KRITIS
         * ======================= */

   $stokKritis = DB::table('varian_obat')
    ->where('alert_minimum', '>', 0)  // ← ganti true jadi > 0
    ->where('stok_minimum', '>', 0)
    ->select(
        'id_varian',
        'nama_merek',
        'dosis_mg',
        'stok_minimum as batas_minimum',
        DB::raw('COALESCE((
            SELECT SUM(s.jumlah) FROM stok_obat s
            WHERE s.id_varian = varian_obat.id_varian
            AND s.tanggal_kadaluarsa > NOW()
        ), 0) as total_stok')
    )
    ->havingRaw('total_stok < batas_minimum')
    ->get();
        /* =======================
         * 3. TREN PEMAKAIAN (CHART)
         * ======================= */

        $trenRaw = DB::table('pemakaian_obat')
            ->selectRaw("DATE_FORMAT(tanggal_pakai, '%Y-%m') as bulan, SUM(jumlah_pakai) as total")
            ->where('tanggal_pakai', '>=', $now->copy()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $trendLabels    = [];
        $trendPemakaian = [];

        $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

        for ($i = 5; $i >= 0; $i--) {
            $key = $now->copy()->subMonths($i)->format('Y-m');
            $bln = (int) $now->copy()->subMonths($i)->format('n');

            $trendLabels[]    = $namaBulan[$bln - 1];
            $trendPemakaian[] = (int) ($trenRaw[$key] ?? 0);
        }

        /* =======================
         * 4. DISTRIBUSI JENIS OBAT (DONUT)
         * ======================= */

        $distribusiRaw = DB::table('jenis_obat')
            ->leftJoin('obat', 'obat.id_jenis', '=', 'jenis_obat.id_jenis')
            ->leftJoin('varian_obat', 'varian_obat.id_obat', '=', 'obat.id_obat')
            ->select('jenis_obat.nama_jenis')
            ->selectRaw('COUNT(varian_obat.id_varian) as jumlah')
            ->groupBy('jenis_obat.id_jenis', 'jenis_obat.nama_jenis')
            ->orderByDesc('jumlah')
            ->get();

        $colors = ['#378ADD', '#4CAF6E', '#F5A623', '#8B7CF6', '#9CA3AF'];

        $distribusiJenis = $distribusiRaw->values()->map(function ($item, $i) use ($colors) {
            return [
                'label' => $item->nama_jenis,
                'value' => (int) $item->jumlah,
                'color' => $colors[$i % count($colors)],
            ];
        });

        /* =======================
         * 5. BATCH MENDEKATI EXPIRED (TABLE)
         * ======================= */

        $batchKadaluarsa = DB::table('stok_obat')
            ->join('varian_obat', 'stok_obat.id_varian', '=', 'varian_obat.id_varian')
            ->select(
                'stok_obat.jumlah',
                'stok_obat.tanggal_kadaluarsa',
                'varian_obat.nama_merek',
                'varian_obat.dosis_mg'
            )
            ->where('stok_obat.tanggal_kadaluarsa', '<=', $limit)
            ->where('stok_obat.jumlah', '>', 0)
            ->orderBy('stok_obat.tanggal_kadaluarsa')
            ->limit(5)
            ->get()
            ->map(function ($item) use ($now) {
                $diff = Carbon::parse($item->tanggal_kadaluarsa)->diffInDays($now, false);
                return [
                    'nama'   => $item->nama_merek . ' ' . $item->dosis_mg . 'mg',
                    'stok'   => $item->jumlah,
                    'exp'    => Carbon::parse($item->tanggal_kadaluarsa)->format('d M'),
                    'status' => $diff <= 7 ? 'kritis' : ($diff <= 30 ? 'segera' : 'aman'),
                ];
            });

        /* =======================
         * 6. PEMAKAIAN TERAKHIR
         * ======================= */

        $pemakaianTerakhir = DB::table('pemakaian_obat')
            ->join('varian_obat', 'pemakaian_obat.id_varian', '=', 'varian_obat.id_varian')
            ->select(
                'pemakaian_obat.jumlah_pakai',
                'pemakaian_obat.tanggal_pakai',
                'varian_obat.nama_merek',
                'varian_obat.dosis_mg'
            )
            ->orderByDesc('tanggal_pakai')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama'  => $item->nama_merek . ' ' . $item->dosis_mg . 'mg',
                    'qty'   => $item->jumlah_pakai,
                    'waktu' => Carbon::parse($item->tanggal_pakai)->diffForHumans(),
                ];
            });

        /* =======================
         * 7. STOK RESTOCK
         * ======================= */

        $stokRestock = $stokKritis->map(function ($item) {
            $pct = $item->batas_minimum > 0
                ? ($item->total_stok / $item->batas_minimum) * 100
                : 0;

            return [
                'nama' => $item->nama_merek . ' ' . $item->dosis_mg . 'mg',
                'stok' => $item->total_stok,
                'min'  => $item->batas_minimum,
                'pct'  => round($pct),
            ];
        });
/* =======================
 * APPROVAL REQUEST
 * ======================= */

$approvalRequestSaya = ApprovalRequest::where('requested_by', auth()->id())
    ->latest()
    ->take(5)
    ->get()
    ->map(function($req) {
        $config         = $req->iconConfig();
        $req->icon_type = $config['type'];
        $req->icon      = $config['icon'];
        return $req;
    });

$pendingApproval = ApprovalRequest::where('requested_by', auth()->id())
    ->where('status', 'pending')
    ->count();
  /* =======================
 * 8. DATA KASIR
 * ======================= */

$transaksiKasir = collect();
$ringkasanKasir = [
    'total_omset'        => 0,
    'total_selesai'      => 0,
    'total_dibatalkan'   => 0,
    'rata_per_transaksi' => 0,
];
$resepHariIni  = 0;
$resepSelesai  = 0;
$resepMenunggu = 0;

try {
    // ── Resep hari ini ──
    $resepHariIni  = DB::table('reseps')->whereDate('created_at', today())->count();
    $resepSelesai  = DB::table('reseps')->whereDate('created_at', today())->where('status', 'selesai')->count();
    $resepMenunggu = DB::table('reseps')->whereDate('created_at', today())->where('status', 'menunggu')->count();

    // ── Ringkasan bulan ini ──
    $totalSelesai = DB::table('reseps')
        ->whereMonth('updated_at', now()->month)
        ->whereYear('updated_at', now()->year)
        ->where('status', 'selesai')
        ->count();

    $totalOmset = DB::table('reseps')
        ->whereMonth('updated_at', now()->month)
        ->whereYear('updated_at', now()->year)
        ->where('status', 'selesai')
        ->sum('total_harga');

   $totalDibatalkan = DB::table('reseps')
    ->whereMonth('updated_at', now()->month)
    ->whereYear('updated_at', now()->year)
    ->where('status', 'batal') // ← bukan 'dibatalkan'
    ->count();

    $rataPerTransaksi = $totalSelesai > 0
        ? $totalOmset / $totalSelesai
        : 0;

    $ringkasanKasir = [
        'total_omset'        => $totalOmset,
        'total_selesai'      => $totalSelesai,
        'total_dibatalkan'   => $totalDibatalkan,
        'rata_per_transaksi' => $rataPerTransaksi,
    ];

    // ── Transaksi terbaru ──
    $transaksiKasir = DB::table('reseps')
        ->leftJoin('users', 'reseps.kasir_id', '=', 'users.id')
        ->whereMonth('reseps.updated_at', now()->month)
        ->whereYear('reseps.updated_at', now()->year)
        ->select(
            'reseps.no_resep',
            'reseps.pasien',
            'reseps.total_harga',
            'reseps.status',
            'reseps.updated_at',
            'users.name as nama_kasir'
        )
        ->orderByDesc('reseps.updated_at')
        ->limit(10)
        ->get()
        ->map(function ($trx) {
            return [
                'no_transaksi' => $trx->no_resep ?? '-',
                'nama_pasien'  => $trx->pasien   ?? '-',
                'nama_kasir'   => $trx->nama_kasir ?? '-',
                'total'        => $trx->total_harga ?? 0,
                'bayar'        => $trx->total_harga ?? 0, // sesuaikan jika ada kolom bayar
                'kembalian'    => 0,                       // sesuaikan jika ada kolom kembalian
                'status'       => $trx->status    ?? '-',
                'waktu'        => \Carbon\Carbon::parse($trx->updated_at)->format('d M Y H:i'),
            ];
        });

} catch (\Exception $e) {
    Log::warning('Gagal ambil data kasir: ' . $e->getMessage());
}
        /* =======================
         * 9. JUMLAH STOK MINIMUM (SIDEBAR BADGE)
         * ======================= */

     $jumlahStokMinimum = DB::table('varian_obat')
    ->where('alert_minimum', '>', 0)  // ← ganti true jadi > 0
    ->where('stok_minimum', '>', 0)
    ->whereRaw('
        COALESCE((
            SELECT SUM(s.jumlah) FROM stok_obat s
            WHERE s.id_varian = varian_obat.id_varian
            AND s.tanggal_kadaluarsa > NOW()
        ), 0) < stok_minimum
    ')
    ->count();

        /* =======================
         * RETURN VIEW
         * ======================= */

        return view('dashboard', compact(
            'totalVariasiObat',
            'totalStok',
            'mendekatiExp',
            'sudahExpire',
            'stokKritis',
            'trendLabels',
            'trendPemakaian',
            'distribusiJenis',
            'batchKadaluarsa',
            'pemakaianTerakhir',
            'stokRestock',
            'transaksiKasir',
            'ringkasanKasir',
            'resepHariIni',
            'resepSelesai',
            'resepMenunggu',
            'jumlahStokMinimum',
            'approvalRequestSaya', 'pendingApproval',
        ));
    }
}
