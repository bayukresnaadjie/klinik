<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use App\Models\Obat;
use Carbon\Carbon;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ── STATISTIK ──────────────────────────────────────────
        $totalResep      = Resep::whereDate('created_at', $today)->count();
        $resepKemarin    = Resep::whereDate('created_at', $today->copy()->subDay())->count();
        $sudahDilayani   = Resep::whereDate('created_at', $today)->where('status', 'selesai')->count();
        $menunggu        = Resep::whereDate('created_at', $today)->where('status', 'menunggu')->count();
        $totalTransaksi  = Resep::whereDate('created_at', $today)->where('status', 'selesai')->sum('total_harga');
        $transaksiKemarin = Resep::whereDate('created_at', $today->copy()->subDay())
    ->where('status', 'selesai')
    ->sum('total_harga');

$transaksiPct = $transaksiKemarin > 0
    ? round((($totalTransaksi - $transaksiKemarin) / $transaksiKemarin) * 100)
    : 0;
       $stokMenipisCount = \App\Models\VarianObat::join('stok_minimum', 'varian_obat.id_varian', '=', 'stok_minimum.id_varian')
    ->whereRaw('
        COALESCE((
            SELECT SUM(jumlah) FROM stok_obat
            WHERE stok_obat.id_varian = varian_obat.id_varian
        ), 0) < stok_minimum.batas_minimum
    ')
    ->count();
        $stats = [
            'total_resep'      => $totalResep,
            'resep_delta'      => $totalResep - $resepKemarin,
            'sudah_dilayani'   => $sudahDilayani,
            'menunggu'         => $menunggu,
            'total_transaksi'  => $totalTransaksi,
            'transaksi_pct' => $transaksiPct,
            'stok_menipis_count' => $stokMenipisCount,
        ];

        // ── ANTREAN RESEP (menunggu) ───────────────────────────
   // ── ANTREAN RESEP (menunggu) ───────────────────────────
$antrean = Resep::whereIn('status', ['menunggu', 'tunda'])
    ->orderBy('created_at')
    ->with('items.varianObat')
    ->take(10)
    ->get()
    ->map(function ($resep) {
        $resep->daftar_obat = $resep->items
            ->map(fn($i) => ($i->varianObat->nama_merek ?? '-') . ' ' . ($i->varianObat->dosis_mg ?? '') . 'mg')
            ->join(' · ');
        $resep->waktu = $resep->created_at;
        $resep->jenis_pembayaran = $resep->jenis_pembayaran ?? 'umum';
        return $resep;
    });
        // ── STOK CEPAT LIHAT ──────────────────────────────────
      $stokCepat = \App\Models\StokObat::with(['varianObat.obat'])
    ->select('id_varian', \Illuminate\Support\Facades\DB::raw('SUM(jumlah) as stok'))
    ->groupBy('id_varian')
    ->orderBy('stok')
    ->take(6)
    ->get()
    ->map(function ($s) {
        $s->nama_obat = ($s->varianObat->nama_merek ?? '-') . ' ' . ($s->varianObat->dosis_mg ?? '') . 'mg';
        $s->kategori  = $s->varianObat?->obat?->nama_obat ?? '-';
        $s->satuan    = 'unit';
        $s->pct       = min(100, round(($s->stok / max($s->varianObat->stok_minimum ?? 100, 1)) * 100));
        return $s;
    });
        // ── ALERTS (stok menipis & hampir kadaluarsa) ─────────
        $alerts = [];

        // Stok di bawah minimum
       $stokMenipis = \App\Models\StokObat::with('varianObat.obat')
    ->select('id_varian', \Illuminate\Support\Facades\DB::raw('SUM(jumlah) as total_stok'))
    ->groupBy('id_varian')
    ->having('total_stok', '<', \Illuminate\Support\Facades\DB::raw('(SELECT stok_minimum FROM varian_obat WHERE id_varian = stok_obat.id_varian)'))
    ->get();

foreach ($stokMenipis as $s) {
    $alerts[] = [
        'id'         => $s->id_varian,
        'nama_obat'  => ($s->varianObat->nama_merek ?? '-') . ' ' . ($s->varianObat->dosis_mg ?? '') . 'mg',
        'keterangan' => 'stok menipis',
        'detail'     => "Sisa {$s->total_stok} unit · Batas minimum: " . ($s->varianObat->stok_minimum ?? 0),
    ];
}

        // Kadaluarsa dalam 30 hari ke depan
       $hampirExp = \App\Models\StokObat::with('varianObat.obat')
    ->where('jumlah', '>', 0)
    ->where('tanggal_kadaluarsa', '>=', $today)
    ->where('tanggal_kadaluarsa', '<=', $today->copy()->addDays(30))
    ->get();
foreach ($hampirExp as $stok) {
    $alerts[] = [
        'id'         => $stok->id_stok,
        'nama_obat'  => ($stok->varianObat->nama_merek ?? '-') . ' ' . ($stok->varianObat->dosis_mg ?? '') . 'mg',
        'keterangan' => 'mendekati kadaluarsa',
        'detail'     => "Sisa {$stok->jumlah} unit · Exp. " . Carbon::parse($stok->tanggal_kadaluarsa)->translatedFormat('d M Y'),
    ];
}
// ── Ringkasan Shift Saya ──────────────────────────────
$resepOlehSaya = Resep::whereDate('created_at', $today)
    ->where('kasir_id', auth()->id())
    ->count();

$omsetOlehSaya = Resep::whereDate('created_at', $today)
    ->where('kasir_id', auth()->id())
    ->where('status', 'selesai')
    ->sum('total_harga');

return view('kasir.dashboard', compact(
    'stats', 'antrean', 'stokCepat', 'alerts',
    'resepOlehSaya', 'omsetOlehSaya'  // ← tambah ini
));
    }
}
