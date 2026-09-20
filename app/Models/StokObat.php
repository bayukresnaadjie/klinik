<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StokObat extends Model
{
    protected $table      = 'stok_obat';
    protected $primaryKey = 'id_stok';

    protected $fillable = [
        'id_varian',
        'no_batch',
        'jumlah',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
    ];

    protected $casts = [
        'tanggal_masuk'       => 'date',
        'tanggal_kadaluarsa'  => 'date',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function varianObat()
    {
        return $this->belongsTo(VarianObat::class, 'id_varian', 'id_varian');
    }

    public function pemakaian()
    {
        return $this->hasMany(PemakaianObat::class, 'id_stok', 'id_stok');
    }

    // ── Accessor ────────────────────────────────────────────

    /**
     * Sisa hari sebelum kadaluarsa (negatif = sudah lewat)
     */
    public function getSisaHariAttribute(): int
    {
        return (int) now()->startOfDay()->diffInDays(
            $this->tanggal_kadaluarsa->startOfDay(),
            false
        );
    }

    /**
     * Label status: 'expired' | 'kritis' (<= 30 hari) | 'warning' (<= 90 hari) | 'aman'
     */
    public function getStatusKadaluarsaAttribute(): string
    {
        $sisa = $this->sisa_hari;
        if ($sisa < 0)   return 'expired';
        if ($sisa <= 30) return 'kritis';
        if ($sisa <= 90) return 'warning';
        return 'aman';
    }

    // ── Scope ───────────────────────────────────────────────

    /** Hanya stok yang masih ada (jumlah > 0) */
    public function scopeAdaStok($query)
    {
        return $query->where('jumlah', '>', 0);
    }

    /** Stok yang kadaluarsa dalam N hari ke depan */
    public function scopeMendekatiKadaluarsa($query, int $hari = 30)
    {
        return $query->where('tanggal_kadaluarsa', '<=', now()->addDays($hari))
                     ->where('tanggal_kadaluarsa', '>=', now())
                     ->where('jumlah', '>', 0);
    }

    /** Stok yang sudah expired */
    public function scopeExpired($query)
    {
        return $query->where('tanggal_kadaluarsa', '<', now()->toDateString());
    }
}
