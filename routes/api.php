<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KasirApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Kasir\ResepController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ── Kasir API (butuh token) ───────────────────────────────
Route::middleware('auth:sanctum')->prefix('kasir')->group(function () {
    Route::get('/obat',             [KasirApiController::class, 'daftarObat']);
    Route::get('/stok/{id_varian}', [KasirApiController::class, 'cekStok']);
    Route::post('/jual',            [KasirApiController::class, 'prosesJual']);
    Route::get('/laporan',          [KasirApiController::class, 'laporan']);
    Route::post('/batalkan',        [KasirApiController::class, 'batalkanTransaksi']);
    Route::get('/transaksi',        [KasirApiController::class, 'riwayatTransaksi']);
});

// ── Transaksi API (publik) ────────────────────────────────
Route::prefix('transaksi')->group(function () {
    Route::get('/',             [TransaksiApiController::class, 'index']);
    Route::get('/rekap-harian', [TransaksiApiController::class, 'rekapHarian']);
    Route::get('/rekap-kasir',  [TransaksiApiController::class, 'rekapKasir']);
    Route::get('/{no}',         [TransaksiApiController::class, 'show']);
});

// ── Resep API (dipanggil oleh kasir 8001) ─────────────────
Route::get('/resep/{id}', function ($id) {
    $resep = \App\Models\Resep::with('items.varianObat')->findOrFail($id);
    return response()->json(['data' => [
        'id'               => $resep->id,
        'no_resep'         => $resep->no_resep,
        'pasien'           => $resep->pasien,
        'dokter'           => $resep->dokter,            // ← tambah
        'umur'             => $resep->umur,              // ← tambah
        'umur_satuan'      => $resep->umur_satuan,       // ← tambah
        'catatan'          => $resep->catatan,           // ← tambah
        'jenis_pembayaran' => $resep->jenis_pembayaran,  // ← tambah
        'total_harga'      => $resep->total_harga,
        'items'            => $resep->items->map(fn($i) => [
            'id_varian'  => $i->id_varian,
            'nama_merek' => $i->varianObat->nama_merek ?? '-',
            'jumlah'     => $i->jumlah,
            'harga'      => $i->harga,
            'subtotal'   => $i->subtotal,
        ]),
    ]]);
});

Route::patch('/resep/{id}/status', [ResepController::class, 'updateStatus']);
