<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarianObat extends Model
{
    protected $table      = 'varian_obat';
    protected $primaryKey = 'id_varian';

    protected $fillable = [
        'id_obat',
        'nama_merek',
        'dosis_mg',
        'harga',
        'stok_minimum',
        'alert_minimum',
    ];

    protected $casts = [
        'harga'         => 'float',
        'stok_minimum'  => 'integer',
        'alert_minimum' => 'boolean',
    ];

    // ── Relasi ───────────────────────────────────────────────────

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id_obat');
    }

    public function stokObat()
    {
        return $this->hasMany(StokObat::class, 'id_varian', 'id_varian');
    }

    public function pemakaianObat()
    {
        return $this->hasMany(PemakaianObat::class, 'id_varian', 'id_varian');
    }

    // ── Accessor ─────────────────────────────────────────────────

    /** Total stok tersedia semua batch aktif */
    public function getTotalStokAttribute(): int
    {
        return $this->stokObat()->adaStok()->sum('jumlah');
    }

    /**
     * Status stok minimum:
     *   'habis'    → stok = 0
     *   'kritis'   → stok > 0 tapi di bawah minimum
     *   'minimum'  → stok = tepat di angka minimum
     *   'aman'     → stok di atas minimum
     *   'no_limit' → tidak ada batas minimum yang diset
     */
    public function getStatusStokAttribute(): string
    {
        if (!$this->alert_minimum || $this->stok_minimum <= 0) {
            return $this->total_stok === 0 ? 'habis' : 'no_limit';
        }

        $stok = $this->total_stok;

        if ($stok === 0)                    return 'habis';
        if ($stok < $this->stok_minimum)    return 'kritis';
        if ($stok === $this->stok_minimum)  return 'minimum';
        return 'aman';
    }

    /** Apakah stok di bawah minimum dan perlu ditampilkan alert */
    public function getBawahMinimumAttribute(): bool
    {
        return $this->alert_minimum
            && $this->stok_minimum > 0
            && $this->total_stok <= $this->stok_minimum;
    }

    // ── Scope ─────────────────────────────────────────────────────

    /** Varian yang stoknya di bawah atau sama dengan minimum */
    public function scopeBawahMinimum($query)
    {
        return $query->where('alert_minimum', true)
                     ->where('stok_minimum', '>', 0)
                     ->whereHas('stokObat', function ($q) {}, '=', 0)
                     ->orWhere(function ($q) {
                         $q->where('alert_minimum', true)
                           ->where('stok_minimum', '>', 0)
                           ->whereRaw('stok_minimum >= (
                               SELECT COALESCE(SUM(jumlah), 0)
                               FROM stok_obat
                               WHERE stok_obat.id_varian = varian_obat.id_varian
                               AND stok_obat.jumlah > 0
                           )');
                     });
    }

    public static function getStokKritis()
{
    return self::with(['obat', 'stokObat'])
        ->where('alert_minimum', true)
        ->where('stok_minimum', '>', 0)
        ->get()
        ->map(function ($v) {
            $stok = $v->stokObat->where('jumlah', '>', 0)->sum('jumlah');

            return [
                'nama_merek'    => $v->nama_merek,
                'dosis_mg'      => $v->dosis_mg,
                'total_stok'    => $stok,
                'batas_minimum' => $v->stok_minimum,
                'status'        => $stok <= 0 ? 'habis' : 'kritis',
            ];
        })
        ->filter(fn ($v) => $v['total_stok'] <= $v['batas_minimum']);
}

    /** Varian yang alert minimum aktif */
    public function scopeAlertAktif($query)
    {
        return $query->where('alert_minimum', true)->where('stok_minimum', '>', 0);
    }

    // Semua riwayat harga
public function riwayatHarga()
{
    return $this->hasMany(HargaVarian::class, 'id_varian', 'id_varian')
                ->orderByDesc('berlaku_mulai');
}

// Harga aktif sekarang
public function hargaAktif()
{
    return $this->hasOne(HargaVarian::class, 'id_varian', 'id_varian')
                ->whereNull('berlaku_sampai')
                ->orWhere('berlaku_sampai', '>=', now()->toDateString())
                ->orderByDesc('berlaku_mulai')
                ->limit(1);
}

// Accessor: ambil harga hari ini
public function getHargaSekarangAttribute(): float
{
    return $this->hargaAktif?->harga ?? 0;
}
}
