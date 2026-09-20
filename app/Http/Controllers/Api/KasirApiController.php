<?php
// ============================================================
// FILE INI DILETAKKAN DI SISTEM OBAT (klinik-yos-benito)
// app/Http/Controllers/Api/KasirApiController.php
// ============================================================

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VarianObat;
use App\Models\StokObat;
use App\Models\PemakaianObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasirApiController extends Controller
{
    /**
     * GET /api/kasir/obat
     * Daftar semua varian obat + total stok untuk ditampilkan di kasir.
     */
    public function daftarObat()
    {
        $data = VarianObat::with('obat.jenisObat')
            ->get()
            ->map(function ($v) {
                return [
                    'id_varian'  => $v->id_varian,
                    'nama_merek' => $v->nama_merek,
                    'nama_obat'  => $v->obat->nama_obat ?? '-',
                    'jenis'      => $v->obat->jenisObat->nama_jenis ?? '-',
                    'dosis_mg'   => $v->dosis_mg,
                    'harga'      => (float) $v->harga,
                    'stok'       => $v->stokObat()->adaStok()->sum('jumlah'),
                ];
            });

        return response()->json([
            'status' => 'ok',
            'data'   => $data,
        ]);
    }

    /**
     * GET /api/kasir/stok/{id_varian}
     * Cek stok tersedia untuk 1 varian (real-time).
     */
    public function cekStok($id_varian)
    {
        $varian = VarianObat::find($id_varian);
        if (!$varian) {
            return response()->json(['status' => 'error', 'message' => 'Varian tidak ditemukan'], 404);
        }

        $stok = StokObat::where('id_varian', $id_varian)
            ->adaStok()
            ->orderBy('tanggal_kadaluarsa')
            ->get()
            ->map(fn($s) => [
                'id_stok'            => $s->id_stok,
                'no_batch'           => $s->no_batch,
                'jumlah'             => $s->jumlah,
                'tanggal_kadaluarsa' => $s->tanggal_kadaluarsa->format('Y-m-d'),
                'status'             => $s->status_kadaluarsa,
            ]);

        return response()->json([
            'status'     => 'ok',
            'id_varian'  => $id_varian,
            'total_stok' => $stok->sum('jumlah'),
            'batches'    => $stok,
        ]);
    }

    /**
     * POST /api/kasir/jual
     * Proses penjualan — kurangi stok FIFO otomatis.
     *
     * Body JSON:
     * {
     *   "items": [
     *     { "id_varian": 1, "jumlah": 5 },
     *     { "id_varian": 3, "jumlah": 2 }
     *   ],
     *   "no_transaksi": "TRX-2024-001",  // opsional
     *   "keterangan": "Kasir penjualan"   // opsional
     * }
     */
    public function prosesJual(Request $request)
    {
        $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.id_varian'  => 'required|exists:varian_obat,id_varian',
            'items.*.jumlah'     => 'required|integer|min:1',
            'no_transaksi'       => 'nullable|string|max:50',
            'keterangan'         => 'nullable|string|max:255',
            'ref_id'             => 'nullable|integer',
        ]);

        $items       = $request->items;
        $noTransaksi = $request->no_transaksi ?? 'TRX-' . now()->format('YmdHis');
        $keterangan  = $request->keterangan ?? 'Penjualan kasir';
        $hasil       = [];
        $errors      = [];

        // Validasi stok semua item dulu sebelum proses
        foreach ($items as $item) {
            $totalStok = StokObat::where('id_varian', $item['id_varian'])
                ->adaStok()->sum('jumlah');

            if ($totalStok < $item['jumlah']) {
                $varian = VarianObat::find($item['id_varian']);
                $errors[] = "Stok {$varian->nama_merek} tidak cukup. "
                    . "Tersedia: {$totalStok}, diminta: {$item['jumlah']}";
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Stok tidak mencukupi',
                'errors'  => $errors,
            ], 422);
        }

        // Proses semua item dalam satu transaksi DB
        DB::transaction(function () use ($items, $noTransaksi, $keterangan, &$hasil) {
            foreach ($items as $item) {
                $sisaAmbil = $item['jumlah'];

                $batches = StokObat::where('id_varian', $item['id_varian'])
                    ->adaStok()
                    ->orderBy('tanggal_kadaluarsa', 'asc')
                    ->get();

                foreach ($batches as $batch) {
                    if ($sisaAmbil <= 0) break;

                    $ambil = min($sisaAmbil, $batch->jumlah);

                    PemakaianObat::create([
                        'id_varian'    => $item['id_varian'],
                        'id_stok'      => $batch->id_stok,
                        'jumlah_pakai' => $ambil,
                        'tanggal_pakai'=> now()->toDateString(),
                        'keterangan'   => "[{$noTransaksi}] {$keterangan}",
                    ]);

                    $batch->decrement('jumlah', $ambil);
                    $sisaAmbil -= $ambil;
                }

                $varian    = VarianObat::find($item['id_varian']);
                $hasil[]   = [
                    'id_varian'  => $item['id_varian'],
                    'nama_merek' => $varian->nama_merek,
                    'jumlah'     => $item['jumlah'],
                    'harga'      => (float) $varian->harga,
                    'subtotal'   => (float) $varian->harga * $item['jumlah'],
                ];
            }
        });

        $total = array_sum(array_column($hasil, 'subtotal'));


        if ($request->filled('ref_id')) {
        try {
            \Illuminate\Support\Facades\Http::withToken(env('KASIR_API_TOKEN'))
                ->patch(env('KASIR_API_URL') . '/api/resep/' . $request->ref_id . '/status', [
                    'status'      => 'selesai',
                    'total_harga' => $total,
                ]);
        } catch (\Exception $e) {
            Log::error('Gagal update status resep ke 8000: ' . $e->getMessage());
        }
    }
        return response()->json([
            'status'       => 'ok',
            'message'      => 'Transaksi berhasil',
            'no_transaksi' => $noTransaksi,
            'items'        => $hasil,
            'total'        => $total,
            'waktu'        => now()->format('d/m/Y H:i:s'),
        ]);
    }

    /**
     * GET /api/kasir/laporan?dari=2024-01-01&sampai=2024-01-31
     * Laporan penjualan per periode (untuk ditampilkan di kasir).
     */
    public function laporan(Request $request)
    {
        $dari   = $request->get('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', now()->toDateString());

        $data = PemakaianObat::with('varianObat.obat')
            ->whereBetween('tanggal_pakai', [$dari, $sampai])
            ->get()
            ->groupBy('id_varian')
            ->map(function ($rows) {
                $varian = $rows->first()->varianObat;
                $jumlah = $rows->sum('jumlah_pakai');
                $harga  = (float) $varian->harga;
                return [
                    'nama_merek' => $varian->nama_merek,
                    'nama_obat'  => $varian->obat->nama_obat ?? '-',
                    'dosis_mg'   => $varian->dosis_mg,
                    'jumlah'     => $jumlah,
                    'harga'      => $harga,
                    'subtotal'   => $harga * $jumlah,
                ];
            })
            ->values();

        return response()->json([
            'status'      => 'ok',
            'periode'     => ['dari' => $dari, 'sampai' => $sampai],
            'total_item'  => $data->sum('jumlah'),
            'total_omset' => $data->sum('subtotal'),
            'data'        => $data,
        ]);
    }

    public function batalkanTransaksi(Request $request)
    {
        $request->validate([
            'no_transaksi'          => 'required|string|max:50',
            'items'                 => 'required|array|min:1',
            'items.*.id_varian'     => 'required|exists:varian_obat,id_varian',
            'items.*.jumlah'        => 'required|integer|min:1',
            'alasan'                => 'nullable|string|max:255',
        ], [
            'no_transaksi.required' => 'Nomor transaksi wajib diisi.',
            'items.required'        => 'Daftar item wajib diisi.',
            'items.*.id_varian.exists' => 'Varian obat tidak ditemukan.',
        ]);

        $noTransaksi = $request->no_transaksi;
        $alasan      = $request->alasan ?? 'Dibatalkan dari kasir';
        $hasil       = [];
        $gagal       = [];

        // Cek apakah transaksi sudah pernah dibatalkan
        // (tandai dengan cek di pemakaian — kalau tidak ada record berarti sudah dibatalkan)
        $sudahDibatalkan = true;
        foreach ($request->items as $item) {
            $ada = PemakaianObat::where('id_varian', $item['id_varian'])
                ->where('keterangan', 'like', "%{$noTransaksi}%")
                ->exists();
            if ($ada) {
                $sudahDibatalkan = false;
                break;
            }
        }

        if ($sudahDibatalkan) {
            return response()->json([
                'status'  => 'error',
                'message' => "Transaksi {$noTransaksi} tidak ditemukan atau sudah pernah dibatalkan.",
            ], 422);
        }

        // Jalankan pengembalian stok dalam satu transaksi DB
        DB::transaction(function () use ($request, $noTransaksi, $alasan, &$hasil, &$gagal) {
            foreach ($request->items as $item) {
                $idVarian   = $item['id_varian'];
                $jumlahBatal = (int) $item['jumlah'];

                // Ambil semua record pemakaian yang terkait transaksi ini
                $pemakaianList = PemakaianObat::where('id_varian', $idVarian)
                    ->where('keterangan', 'like', "%{$noTransaksi}%")
                    ->with('stokObat')
                    ->get();

                if ($pemakaianList->isEmpty()) {
                    $varian  = VarianObat::find($idVarian);
                    $gagal[] = [
                        'id_varian'  => $idVarian,
                        'nama_merek' => $varian->nama_merek ?? '-',
                        'pesan'      => 'Record pemakaian tidak ditemukan untuk transaksi ini.',
                    ];
                    return; // lanjut item berikutnya
                }

                $sisaKembali = $jumlahBatal;

                foreach ($pemakaianList as $pemakaian) {
                    if ($sisaKembali <= 0) break;

                    $kembalikan = min($sisaKembali, $pemakaian->jumlah_pakai);

                    // Kembalikan stok ke batch asal
                    if ($pemakaian->stokObat) {
                        $pemakaian->stokObat->increment('jumlah', $kembalikan);
                    } else {
                        // Batch sudah dihapus — kembalikan ke batch manapun yang masih ada
                        // atau buat entri stok baru
                        $batchAda = StokObat::where('id_varian', $idVarian)->first();
                        if ($batchAda) {
                            $batchAda->increment('jumlah', $kembalikan);
                        } else {
                            StokObat::create([
                                'id_varian'          => $idVarian,
                                'no_batch'           => 'RETUR-' . $noTransaksi,
                                'jumlah'             => $kembalikan,
                                'tanggal_masuk'      => now()->toDateString(),
                                'tanggal_kadaluarsa' => now()->addYears(2)->toDateString(),
                            ]);
                        }
                    }

                    // Hapus atau kurangi record pemakaian
                    if ($kembalikan >= $pemakaian->jumlah_pakai) {
                        $pemakaian->delete();
                    } else {
                        $pemakaian->decrement('jumlah_pakai', $kembalikan);
                    }

                    $sisaKembali -= $kembalikan;
                }

                $varian  = VarianObat::find($idVarian);
                $hasil[] = [
                    'id_varian'       => $idVarian,
                    'nama_merek'      => $varian->nama_merek ?? '-',
                    'jumlah_dikembalikan' => $jumlahBatal - $sisaKembali,
                    'stok_sekarang'   => StokObat::where('id_varian', $idVarian)->adaStok()->sum('jumlah'),
                ];
            }
        });

        // Log pembatalan untuk audit trail
        Log::channel('daily')->info('Transaksi dibatalkan via kasir', [
            'no_transaksi' => $noTransaksi,
            'alasan'       => $alasan,
            'items'        => $hasil,
            'gagal'        => $gagal,
            'by_token'     => $request->user()?->name ?? 'api',
        ]);

        // Kalau ada item yang gagal dikembalikan
        if (!empty($gagal)) {
            return response()->json([
                'status'  => 'partial',
                'message' => 'Sebagian stok berhasil dikembalikan, sebagian gagal.',
                'berhasil'=> $hasil,
                'gagal'   => $gagal,
            ], 207);
        }

        return response()->json([
            'status'       => 'ok',
            'message'      => "Transaksi {$noTransaksi} berhasil dibatalkan. Stok dikembalikan.",
            'no_transaksi' => $noTransaksi,
            'items'        => $hasil,
        ]);
    }

    /**
     * GET /api/kasir/transaksi?dari=2024-01-01&sampai=2024-01-31&no=TRX-xxx
     *
     * Riwayat transaksi dari sisi sistem obat (berdasarkan pemakaian).
     * Berguna untuk rekonsiliasi antara kasir dan sistem obat.
     */
    public function riwayatTransaksi(Request $request)
    {
        $dari   = $request->get('dari',   now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', now()->toDateString());
        $noTrx  = $request->get('no');

        $query = PemakaianObat::with('varianObat.obat')
            ->whereBetween('tanggal_pakai', [$dari, $sampai])
            ->where('keterangan', 'like', '%TRX-%'); // hanya dari kasir

        if ($noTrx) {
            $query->where('keterangan', 'like', "%{$noTrx}%");
        }

        $pemakaian = $query->get();

        // Group by no transaksi
        $transaksi = $pemakaian
            ->groupBy(fn($p) => $this->extractNoTransaksi($p->keterangan))
            ->map(function ($items, $noTrx) {
                return [
                    'no_transaksi' => $noTrx,
                    'tanggal'      => $items->first()->tanggal_pakai->format('Y-m-d'),
                    'jumlah_item'  => $items->count(),
                    'total_unit'   => $items->sum('jumlah_pakai'),
                    'items'        => $items->map(fn($p) => [
                        'id_varian'  => $p->id_varian,
                        'nama_merek' => $p->varianObat->nama_merek ?? '-',
                        'jumlah'     => $p->jumlah_pakai,
                        'harga'      => (float) ($p->varianObat->harga ?? 0),
                        'subtotal'   => (float) ($p->varianObat->harga ?? 0) * $p->jumlah_pakai,
                    ])->values(),
                ];
            })
            ->values();

        return response()->json([
            'status'   => 'ok',
            'periode'  => ['dari' => $dari, 'sampai' => $sampai],
            'total'    => $transaksi->count(),
            'data'     => $transaksi,
        ]);
    }

    // Helper: ekstrak no transaksi dari keterangan
    private function extractNoTransaksi(string $keterangan): string
    {
        preg_match('/\[(TRX-[^\]]+)\]/', $keterangan, $matches);
        return $matches[1] ?? $keterangan;
    }
}

