<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $data = Pembayaran::with('resep')->orderByDesc('created_at')->paginate(15);
        return view('kasir.pembayaran.index', compact('data'));
    }

    // Dipanggil dari tombol 💳 Bayar di daftar resep
    // URL: /kasir/pembayaran/create?resep_id=XX
    public function create(Request $request)
    {
        $resep = Resep::with('items.varianObat.obat')
                      ->findOrFail($request->resep_id);

        if ($resep->status === 'selesai') {
            return redirect()->route('kasir.resep.index')
                             ->with('error', 'Resep ini sudah lunas.');
        }

        return view('kasir.pembayaran.create', compact('resep'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resep_id'     => 'required|exists:reseps,id',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode'       => 'required|in:tunai,transfer,bpjs,asuransi',
        ]);

        $resep = Resep::findOrFail($request->resep_id);

        if ($resep->status === 'selesai') {
            return back()->with('error', 'Resep ini sudah lunas.');
        }

        $pembayaran = Pembayaran::create([
            'resep_id'      => $resep->id,
            'total_tagihan' => $resep->total_harga,
            'jumlah_bayar'  => $request->jumlah_bayar,
            'kembalian'     => max(0, $request->jumlah_bayar - $resep->total_harga),
            'metode'        => $request->metode,
            'kasir_id'      => auth()->id(),
            'paid_at'       => now(),
        ]);

        $resep->update(['status' => 'selesai']);

        return redirect()->route('kasir.pembayaran.show', $pembayaran->id)
                         ->with('success', 'Pembayaran berhasil diproses.');
    }

    // Struk pembayaran
    public function show($id)
    {
        $pembayaran = Pembayaran::with('resep.items.varianObat')->findOrFail($id);
        return view('kasir.pembayaran.show', compact('pembayaran'));
    }

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id)
    {
        Pembayaran::findOrFail($id)->delete();
        return redirect()->route('kasir.pembayaran.index')
                         ->with('success', 'Data pembayaran dihapus.');
    }
}
