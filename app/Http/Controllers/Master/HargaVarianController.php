<?php
// app/Http/Controllers/Master/HargaVarianController.php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\HargaVarian;
use App\Models\VarianObat;
use App\Services\HargaVarianService;
use Illuminate\Http\Request;

class HargaVarianController extends Controller
{
    public function __construct(private HargaVarianService $service) {}

    // Tampilkan riwayat harga 1 varian
    public function show(int $idVarian)
    {
        $varian  = VarianObat::with(['obat.jenisObat', 'riwayatHarga'])->findOrFail($idVarian);
        return view('master.harga-varian.show', compact('varian'));
    }

    // Form ubah harga
    public function edit(int $idVarian)
    {
        $varian = VarianObat::with('hargaAktif')->findOrFail($idVarian);
        return view('master.harga-varian.edit', compact('varian'));
    }

    // Simpan harga baru
    public function update(Request $request, int $idVarian)
    {
        $data = $request->validate([
            'harga'         => 'required|numeric|min:0',
            'berlaku_mulai' => 'required|date|after_or_equal:today',
        ]);

        $this->service->setHarga($idVarian, $data['harga'], $data['berlaku_mulai']);

        return redirect()
            ->route('master.varian-obat.index')
            ->with('success', 'Harga berhasil diperbarui. Harga baru berlaku mulai '
                . \Carbon\Carbon::parse($data['berlaku_mulai'])->isoFormat('D MMMM Y') . '.');
    }

    public function list(int $idVarian): \Illuminate\Http\JsonResponse
{
    $riwayat = \App\Models\HargaVarian::where('id_varian', $idVarian)
        ->orderByDesc('berlaku_mulai')
        ->get(['harga', 'berlaku_mulai', 'berlaku_sampai']);

    return response()->json($riwayat);
}
}
