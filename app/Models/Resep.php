<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $fillable = [
        'no_resep',
        'pasien',
        'jenis_pembayaran',      // string nama pasien, BUKAN foreign key
        'dokter',
        'status',
        'total_harga',
        'catatan',
    ];

    // ← HAPUS method pasien() yang pakai belongsTo

    public function items()
    {
        return $this->hasMany(ResepItem::class, 'resep_id');
    }
}
