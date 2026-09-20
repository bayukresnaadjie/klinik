<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'resep_id',
        'total_tagihan',
        'jumlah_bayar',
        'kembalian',
        'metode',
        'kasir_id',
        'paid_at',
    ];

    protected $casts = [
        'paid_at'       => 'datetime',
        'total_tagihan' => 'decimal:2',
        'jumlah_bayar'  => 'decimal:2',
        'kembalian'     => 'decimal:2',
    ];

    // ── Relasi ───────────────────────────────────────────

    public function resep()
    {
        return $this->belongsTo(Resep::class, 'resep_id');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    // ── Accessor ─────────────────────────────────────────

    // Format label metode pembayaran
    public function getLabelMetodeAttribute(): string
    {
        return match ($this->metode) {
            'tunai'     => '💵 Tunai',
            'transfer'  => '🏦 Transfer',
            'bpjs'      => '🏥 BPJS',
            'asuransi'  => '📋 Asuransi',
            default     => ucfirst($this->metode),
        };
    }
}
