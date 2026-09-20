<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemakaianObat extends Model
{
    protected $table      = 'pemakaian_obat';
    protected $primaryKey = 'id_pakai';

    protected $fillable = [
        'id_varian',
        'id_stok',
        'jumlah_pakai',
        'tanggal_pakai',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pakai' => 'date',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function varianObat()
    {
        return $this->belongsTo(VarianObat::class, 'id_varian', 'id_varian');
    }

    public function stokObat()
    {
        return $this->belongsTo(StokObat::class, 'id_stok', 'id_stok');
    }
}
