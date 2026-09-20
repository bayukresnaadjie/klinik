<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use App\Models\StokObat;
use App\Models\VarianObat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ResepController extends Controller
{
    // Daftar semua resep
    public function index()
    {
        $data = Resep::orderByDesc('created_at')->paginate(10);

        return view('kasir.resep.index', compact('data'));
    }

    // Form buat resep baru
   public function create()
{
    $varian = VarianObat::with('obat')->orderBy('nama_merek')->get();

    $varianJson = $varian->map(fn($v) => [
        'id'    => $v->id_varian,
        'merek' => $v->nama_merek,
        'dosis' => $v->dosis_mg,
        'nama'  => $v->obat->nama_obat ?? '',
    ])->values();

    return view('kasir.resep.create', compact('varian', 'varianJson'));
}

    // Simpan resep baru
    // Simpan resep baru
public function store(Request $request)
{
    $request->validate([
        'nama_pasien'       => 'required|string|max:100',
        'items'             => 'required|array|min:1',
        'items.*.id_varian' => 'required|exists:varian_obat,id_varian',
        'items.*.jumlah'    => 'required|integer|min:1',
    ]);

    $resep = Resep::create([
        'no_resep'         => 'RES-' . date('Ymd') . '-' . str_pad(\App\Models\Resep::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
        'pasien'           => $request->nama_pasien,
        'jenis_pembayaran' => $request->jenis_pembayaran ?? 'umum',
        'status'           => 'menunggu',
        'total_harga'      => 0,
    ]);

    $total     = 0;
    $itemsData = [];

    foreach ($request->items as $item) {
        $varian   = VarianObat::find($item['id_varian']);
        $subtotal = ($varian->harga ?? 0) * $item['jumlah'];
        $total   += $subtotal;

        $resep->items()->create([
            'id_varian'        => $item['id_varian'],
            'jumlah'           => $item['jumlah'],
            'satuan'           => $item['satuan']            ?? null,
            'sigma1'           => $item['sigma1']            ?? null,
            'sigma2'           => $item['sigma2']            ?? null,
            'qty1'             => $item['qty1']              ?? 0,
            'pagi'             => $item['pagi']              ?? 0,
            'siang'            => $item['siang']             ?? 0,
            'sore'             => $item['sore']              ?? 0,
            'malam'            => $item['malam']             ?? 0,
            'qty2'             => $item['qty2']              ?? 0,
            'keterangan_pakai' => $item['keterangan_pakai']  ?? null,
            'harga'            => $varian->harga ?? 0,
            'subtotal'         => $subtotal,
        ]);

        $itemsData[] = [
            'nama_obat' => $varian->nama_merek,
            'jumlah'    => $item['jumlah'],
            'harga'     => $varian->harga ?? 0,
            'subtotal'  => $subtotal,
        ];
    } // ← pastikan kurung kurawal foreach ada di sini

    $resep->update(['total_harga' => $total]);

    // ===== KIRIM KE SISTEM KASIR 8001 =====
    try {
        $response = \Illuminate\Support\Facades\Http::withToken(env('KASIR_API_TOKEN'))
            ->post(env('KASIR_API_URL') . '/api/transaksi/terima', [
                'ref_id'      => $resep->id,
                'nama_pasien' => $resep->pasien,
                'total'       => $total,
                'items'       => $itemsData,
            ]);

        if ($response->successful()) {
            $transaksi_id = $response->json('transaksi_id');
            return redirect(env('KASIR_API_URL') . '/kasir/transaksi/' . $transaksi_id . '/dari-resep');
        }
    } catch (\Exception $e) {
        \Log::error('Gagal kirim ke kasir: ' . $e->getMessage());
    }

    return redirect()->route('kasir.resep.index')
                     ->with('success', 'Resep berhasil dibuat.');
}
    // Detail resep
    public function show($id)
    {
       $resep = Resep::with(['items.varianObat.obat'])->findOrFail($id);

        return view('kasir.resep.show', compact('resep'));
    }

    // Form edit resep
    public function edit($id)
    {
        $resep  = Resep::with('items.varianObat')->findOrFail($id);
        $varian = VarianObat::with('obat')->orderBy('nama_merek')->get();

        return view('kasir.resep.edit', compact('resep', 'varian'));
    }

    // Update resep
  public function update(Request $request, $id)
{
    $request->validate([
        'nama_pasien'       => 'required|string|max:100',
        'items'             => 'required|array|min:1',
        'items.*.id_varian' => 'required|exists:varian_obat,id_varian',
        'items.*.jumlah'    => 'required|integer|min:1',
    ]);

    $resep = Resep::findOrFail($id);

    $resep->update([
        'pasien'  => $request->nama_pasien,
        'dokter'  => $request->dokter,
        'catatan' => $request->catatan,
    ]);

    // Hapus items lama dulu, baru simpan yang baru
    $resep->items()->delete();

    $total = 0;
   foreach ($request->items as $item) {
    $varian   = VarianObat::find($item['id_varian']);
    $subtotal = ($varian->harga ?? 0) * $item['jumlah'];
    $total   += $subtotal;

    $resep->items()->create([
        'id_varian'       => $item['id_varian'],
        'jumlah'          => $item['jumlah'],
        'satuan'          => $item['satuan']          ?? null,
        'sigma1'          => $item['sigma1']          ?? null,
        'sigma2'          => $item['sigma2']          ?? null,
        'qty1'            => $item['qty1']            ?? 0,
        'pagi'            => $item['pagi']            ?? 0,
        'siang'           => $item['siang']           ?? 0,
        'sore'            => $item['sore']            ?? 0,
        'malam'           => $item['malam']           ?? 0,
        'qty2'            => $item['qty2']            ?? 0,
        'keterangan_pakai'=> $item['keterangan_pakai']?? null,
        'harga'           => $varian->harga ?? 0,
        'subtotal'        => $subtotal,
    ]);
    }

    $resep->update(['total_harga' => $total]);

    return redirect()->route('kasir.resep.show', $resep->id)
                     ->with('success', 'Resep berhasil diperbarui.');
}
    // Hapus resep
    public function destroy($id)
    {
        Resep::findOrFail($id)->delete();

        return redirect()->route('kasir.resep.index')
                         ->with('success', 'Resep berhasil dihapus.');
    }

    // Dipanggil oleh sistem kasir 8001 setelah pembayaran selesai
public function updateStatus(Request $request, $id)
{
    $resep = Resep::findOrFail($id);

    $resep->update([
        'status'      => $request->status,
        'total_harga' => $request->total_harga ?? $resep->total_harga, // ← tambah ini
    ]);

    return response()->json([
        'message' => 'Status resep diperbarui',
        'status'  => $resep->status,
    ]);
}
}
