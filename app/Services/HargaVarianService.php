<?php
// app/Services/HargaVarianService.php

namespace App\Services;

use App\Models\HargaVarian;
use Carbon\Carbon;

class HargaVarianService
{
    /**
     * Set harga baru untuk varian.
     * Harga lama akan ditutup di hari sebelum berlaku_mulai baru.
     */
    public function setHarga(int $idVarian, float $harga, string $berlakuMulai): HargaVarian
    {
        $mulai = Carbon::parse($berlakuMulai)->toDateString();

        // Tutup harga yang masih aktif (berlaku_sampai = null)
        HargaVarian::where('id_varian', $idVarian)
            ->whereNull('berlaku_sampai')
            ->update([
                'berlaku_sampai' => Carbon::parse($mulai)
                                          ->subDay()
                                          ->toDateString(),
            ]);

        // Simpan harga baru
        return HargaVarian::create([
            'id_varian'      => $idVarian,
            'harga'          => $harga,
            'berlaku_mulai'  => $mulai,
            'berlaku_sampai' => null, // null = masih aktif
        ]);
    }

    /**
     * Ambil harga aktif pada tanggal tertentu.
     */
    public function getHargaPadaTanggal(int $idVarian, string $tanggal): ?HargaVarian
    {
        return HargaVarian::where('id_varian', $idVarian)
            ->where('berlaku_mulai', '<=', $tanggal)
            ->where(function ($q) use ($tanggal) {
                $q->whereNull('berlaku_sampai')
                  ->orWhere('berlaku_sampai', '>=', $tanggal);
            })
            ->orderByDesc('berlaku_mulai')
            ->first();
    }
}
