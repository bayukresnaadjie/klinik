<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // ── Ambil notifikasi via AJAX (polling) ────────────────────
    public function index()
    {
        $notifications = Notification::forUser(Auth::id())
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($n) => [
                'id'      => $n->id,
                'type'    => $n->type,
                'title'   => $n->title,
                'message' => $n->message,
                'url'     => $n->url,
                'is_read' => $n->is_read,
                'time'    => $n->created_at->diffForHumans(),
                'icon'    => $n->iconConfig(),
            ]);

        $unreadCount = Notification::forUser(Auth::id())
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    // ── Tandai satu notifikasi sudah dibaca ────────────────────
    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // ── Tandai semua sudah dibaca ──────────────────────────────
    public function markAllRead()
    {
        Notification::forUser(Auth::id())
            ->unread()
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
