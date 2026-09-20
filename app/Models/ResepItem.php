<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepItem extends Model
{
    protected $fillable = [
    'resep_id',
    'id_varian',
    'jumlah',
    'satuan',       // ← baru
    'sigma1',       // ← baru
    'sigma2',       // ← baru
    'qty1',         // ← baru
    'pagi',         // ← baru
    'siang',        // ← baru
    'sore',         // ← baru
    'malam',        // ← baru
    'qty2',         // ← baru
    'keterangan_pakai', // ← baru
    'harga',
    'subtotal',
];

    // Relasi balik ke Resep
    public function resep()
    {
        return $this->belongsTo(Resep::class, 'resep_id');
    }

    // Relasi ke VarianObat — dipakai di show() dan edit()
    public function varianObat()
    {
        return $this->belongsTo(VarianObat::class, 'id_varian');
    }
}
