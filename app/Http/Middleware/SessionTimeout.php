<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    // Durasi timeout dalam detik (30 menit)
    private const TIMEOUT_SECONDS = 1800;

    public function handle(Request $request, Closure $next): Response
    {

        // Lewati jika belum login
        if (! Auth::check()) {
            return $next($request);
        }

        // Lewati request AJAX — jangan redirect di tengah fetch
        if ($request->ajax() || $request->wantsJson()) {
            $lastActivity = session('last_activity_at', now()->timestamp);
            if (now()->timestamp - $lastActivity > self::TIMEOUT_SECONDS) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json(['timeout' => true], 401);
            }
            session(['last_activity_at' => now()->timestamp]);
            return $next($request);
        }

        // Cek waktu terakhir aktif
        if (session()->has('last_activity_at')) {
            $idle = now()->timestamp - session('last_activity_at');

            if ($idle > self::TIMEOUT_SECONDS) {
                // Logout dan hapus session
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('timeout_message', 'Sesi Anda telah berakhir karena tidak aktif selama 30 menit. Silakan masuk kembali.');
            }
        }

        // Perbarui waktu aktif terakhir
        session(['last_activity_at' => now()->timestamp]);

        return $next($request);
    }
}
