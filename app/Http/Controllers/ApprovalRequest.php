<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalRequest extends Model
{
    use HasFactory;

    protected $table = 'approval_requests';

    protected $fillable = [
        'judul', 'deskripsi', 'tipe',
        'status', 'detail',
        'requested_by',
        'approved_by', 'approved_at', 'reject_reason',
    ];

    protected $casts = [
        'detail'      => 'array',
        'approved_at' => 'datetime',
    ];

    // ── Relations ──────────────────────────────────────────────
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ── Scopes ─────────────────────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByRole($query, $user)
    {
        return $user->role === 'admin'
            ? $query->where('requested_by', $user->id)
            : $query;
    }

    // ── Helpers ────────────────────────────────────────────────
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function iconConfig(): array
    {
        return match ($this->tipe) {
            'restock'     => ['type' => 'warn',   'icon' => 'truck-delivery'],
            'supplier'    => ['type' => 'info',   'icon' => 'exchange'],
            'hapus_batch' => ['type' => 'danger', 'icon' => 'trash'],
            'tambah_obat' => ['type' => 'ok',     'icon' => 'pill'],
            default       => ['type' => 'info',   'icon' => 'file-text'],
        };
    }

    // ── Stats ──────────────────────────────────────────────────
    public static function counts(): array
    {
        return [
            'pending'  => self::where('status', 'pending')->count(),
            'approved' => self::where('status', 'approved')->count(),
            'rejected' => self::where('status', 'rejected')->count(),
            'all'      => self::count(),
        ];
    }

    public static function managerStats(int $managerId): array
    {
        $row = self::where('approved_by', $managerId)
            ->whereIn('status', ['approved', 'rejected'])
            ->selectRaw('
                COUNT(*) as total,
                SUM(status = "approved") as total_approved,
                SUM(status = "rejected") as total_rejected
            ')
            ->first();

        $avg = self::where('approved_by', $managerId)
            ->whereIn('status', ['approved', 'rejected'])
            ->whereNotNull('approved_at')
            ->get()
            ->avg(fn($r) => $r->created_at->diffInDays($r->approved_at));

        return [
            'total'          => $row->total ?? 0,
            'total_approved' => $row->total_approved ?? 0,
            'total_rejected' => $row->total_rejected ?? 0,
            'avg_response'   => $avg ? round($avg, 1) : 0,
        ];
    }
}
