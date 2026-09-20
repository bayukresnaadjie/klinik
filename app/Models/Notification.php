<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ─────────────────────────────────────────────────
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ── Helpers ────────────────────────────────────────────────
    public static function kirim(int $userId, string $type, string $title, string $message, ?string $url = null): self
    {
        return self::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'url'     => $url,
            'is_read' => false,
        ]);
    }

    public function iconConfig(): array
    {
        return match ($this->type) {
            'approval_approved' => ['icon' => 'circle-check',   'color' => '#16A34A', 'bg' => '#DCFCE7'],
            'approval_rejected' => ['icon' => 'circle-x',       'color' => '#DC2626', 'bg' => '#FEE2E2'],
            'approval_new'      => ['icon' => 'clipboard-check', 'color' => '#D97706', 'bg' => '#FEF3C7'],
            'stok_menipis'      => ['icon' => 'alert-triangle',  'color' => '#DC2626', 'bg' => '#FEE2E2'],
            'stok_kadaluarsa'   => ['icon' => 'calendar-x',      'color' => '#D97706', 'bg' => '#FEF3C7'],
            default             => ['icon' => 'bell',            'color' => '#6B7280', 'bg' => '#F3F4F6'],
        };
    }
}
