<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table      = 'supplier';
    protected $primaryKey = 'id_supplier';

    protected $fillable = [
        'nama',
        'kota',
        'alamat',
        'kontak',
        'email',
        'rating',
        'aktif',
    ];

    protected $casts = [
        'aktif'  => 'boolean',
        'rating' => 'decimal:1',
    ];

    // ── Relasi ────────────────────────────────────────────────────

    /**
     * Semua batch stok yang disuplai oleh supplier ini.
     */
    public function stokObat()
    {
        return $this->hasMany(StokObat::class, 'id_supplier', 'id_supplier');
    }

    public function pengiriman()
{
    return $this->hasMany(PengirimanSupplier::class, 'supplier_id', 'id_supplier');
}
    // ── Scopes ────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeNonAktif($query)
    {
        return $query->where('aktif', false);
    }

    // ── Accessors ─────────────────────────────────────────────────

    /**
     * Inisial 2 huruf untuk avatar.
     */
    public function getInisialAttribute(): string
    {
        return strtoupper(
            collect(explode(' ', $this->nama))
                ->take(2)
                ->map(fn($w) => substr($w, 0, 1))
                ->join('')
        );
    }

    /**
     * Label rating: Sangat Baik / Cukup / Perlu Evaluasi.
     */
    public function getLabelRatingAttribute(): string
    {
        return match(true) {
            $this->rating >= 4   => 'Sangat Baik',
            $this->rating >= 2.5 => 'Cukup',
            default              => 'Perlu Evaluasi',
        };
    }

    /**
     * CSS pill class untuk rating.
     */
    public function getPillRatingAttribute(): string
    {
        return match(true) {
            $this->rating >= 4   => 'pill-ok',
            $this->rating >= 2.5 => 'pill-warn',
            default              => 'pill-danger',
        };
    }
}
