<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengirimanSupplier extends Model
{
    use HasFactory;

    protected $table = 'pengiriman_supplier';

    protected $fillable = [
        'supplier_id',
        'tanggal_kirim',
        'tanggal_terima',
        'keterangan',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal_kirim'  => 'date',
        'tanggal_terima' => 'date',
    ];

    // ── Relations ──────────────────────────────────────────────
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id_supplier');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Scopes ─────────────────────────────────────────────────
    public function scopeTerbaru($query)
    {
        return $query->latest('tanggal_kirim');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // ── Helpers ────────────────────────────────────────────────
    public function badgeConfig(): array
    {
        return match ($this->status) {
            'dikirim'    => ['bg' => '#FEF3C7', 'color' => '#92400E', 'label' => '🚚 Dikirim'],
            'diterima'   => ['bg' => '#DCFCE7', 'color' => '#166534', 'label' => '✔ Diterima'],
            'dibatalkan' => ['bg' => '#FEE2E2', 'color' => '#991B1B', 'label' => '✕ Dibatalkan'],
            default      => ['bg' => '#F3F4F6', 'color' => '#6B7280', 'label' => $this->status],
        };
    }
}
