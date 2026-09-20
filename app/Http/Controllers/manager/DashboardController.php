<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRequest;
use App\Models\PemakaianObat;
use App\Models\PengirimanSupplier;
use App\Models\StokObat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today        = Carbon::today()->toDateString();
        $thisMonth    = Carbon::now()->startOfMonth()->toDateString();
        $lastMonth    = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // ── KPI ───────────────────────────────────────────────────
        $totalStok     = StokObat::sum('jumlah');
        $totalStokLalu = StokObat::where('updated_at', '<', $thisMonth)->sum('jumlah');
        $stokTrend     = $totalStokLalu > 0
            ? round((($totalStok - $totalStokLalu) / $totalStokLalu) * 100)
            : 0;

        $pemakaianBulanIni  = PemakaianObat::whereBetween('tanggal_pakai', [$thisMonth, $today])->sum('jumlah_pakai');
        $pemakaianBulanLalu = PemakaianObat::whereBetween('tanggal_pakai', [$lastMonth, $lastMonthEnd])->sum('jumlah_pakai');
        $pemakaianTrend     = $pemakaianBulanLalu > 0
            ? round((($pemakaianBulanIni - $pemakaianBulanLalu) / $pemakaianBulanLalu) * 100)
            : 0;

        $pendingApproval = ApprovalRequest::where('status', 'pending')->count();

        $totalVarianAktif = StokObat::distinct('id_varian')->count('id_varian');
        $obatBergerak     = PemakaianObat::whereBetween('tanggal_pakai', [$thisMonth, $today])
            ->distinct('id_varian')->count('id_varian');
        $efisiensiStok    = $totalVarianAktif > 0
            ? round(($obatBergerak / $totalVarianAktif) * 100)
            : 0;

        $lastWeekStart    = Carbon::now()->subWeek()->startOfWeek()->toDateString();
        $thisWeekStart    = Carbon::now()->startOfWeek()->toDateString();
        $obatBergerakLalu = PemakaianObat::whereBetween('tanggal_pakai', [$lastWeekStart, $thisWeekStart])
            ->distinct('id_varian')->count('id_varian');
        $efisiensiLalu    = $totalVarianAktif > 0
            ? round(($obatBergerakLalu / $totalVarianAktif) * 100)
            : 0;
        $efisiensiTrend   = $efisiensiStok - $efisiensiLalu;

        // ── Mini Stats ────────────────────────────────────────────
        $staffAktif       = User::whereIn('role', ['admin', 'apoteker', 'kasir', 'manajer'])->count();
        $transaksiHariIni = PemakaianObat::where('tanggal_pakai', $today)->count();
        $batchMendekatiExp = StokObat::whereNotNull('tanggal_kadaluarsa')
            ->where('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(30)->toDateString())
            ->where('jumlah', '>', 0)
            ->count();

        // ── Pengiriman Supplier ───────────────────────────────────
        $pengirimanBulanIni = PengirimanSupplier::whereMonth('tanggal_kirim', now()->month)
            ->whereYear('tanggal_kirim', now()->year)
            ->count();

      // ── Tren Chart ────────────────────────────────────────────
$namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

$trenRaw = PemakaianObat::select(
        DB::raw("DATE_FORMAT(tanggal_pakai, '%Y-%m') as ym"),
        DB::raw('SUM(jumlah_pakai) as total')
    )
    ->where('tanggal_pakai', '>=', Carbon::now()->subMonths(5)->startOfMonth()->toDateString())
    ->groupBy('ym')
    ->orderBy('ym')
    ->pluck('total', 'ym');

// Isi semua 6 bulan terakhir meski data 0
$trendLabels = [];
$trendValues = [];

for ($i = 5; $i >= 0; $i--) {
    $key = Carbon::now()->subMonths($i)->format('Y-m');
    $bln = (int) Carbon::now()->subMonths($i)->format('n');
    $trendLabels[] = $namaBulan[$bln - 1];
    $trendValues[] = (int) ($trenRaw[$key] ?? 0);
}

$trendData = collect(array_map(null, $trendLabels, $trendValues))
    ->map(fn($item) => (object)['bulan' => $item[0], 'total' => $item[1]]);
        // ── Approval Requests ─────────────────────────────────────
        $approvalRequests = ApprovalRequest::with('requester')
            ->where('status', 'pending')
            ->latest()
            ->take(4)
            ->get()
            ->map(function($req) {
                $config       = $req->iconConfig();
                $req->icon_type = $config['type'];
                $req->icon      = $config['icon'];
                return $req;
            });

        // ── Pemakaian Terakhir ────────────────────────────────────
        $pemakaianTerakhir = DB::table('pemakaian_obat as p')
            ->join('varian_obat as v', 'v.id_varian', '=', 'p.id_varian')
            ->join('obat as o',        'o.id_obat',   '=', 'v.id_obat')
            ->select(
                DB::raw("CONCAT(o.nama_obat, ' ', v.nama_merek, ' ', v.dosis_mg, 'mg') as nama_obat"),
                DB::raw("'Tablet' as jenis"),
                'p.jumlah_pakai as qty',
                'p.tanggal_pakai as waktu',
                'p.created_at as created',
                'p.id_varian'
            )
            ->orderByDesc('p.created_at')
            ->limit(10)
            ->get()
            ->map(function($p) {
                $stokSisa     = StokObat::where('id_varian', $p->id_varian)->sum('jumlah');
                $p->stok_sisa = $stokSisa;
                $p->stok_maks = $stokSisa + $p->qty;
                return $p;
            });

        $notifCount = $pendingApproval + $batchMendekatiExp;

       return view('manager.dashboard', compact(
    'totalStok',          'stokTrend',
    'pemakaianBulanIni',  'pemakaianTrend',
    'pendingApproval',
    'efisiensiStok',      'efisiensiTrend',
    'staffAktif',         'transaksiHariIni',  'batchMendekatiExp',
    'pengirimanBulanIni',
    'trendData',          'trendLabels',       'trendValues',
    'approvalRequests',
    'pemakaianTerakhir',
    'notifCount',
));
    }
}
