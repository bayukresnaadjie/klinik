<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cek apakah user yang login memiliki role yang diizinkan.
 *
 * Cara pakai di route:
 *   Route::middleware('role:admin')
 *   Route::middleware('role:admin,apoteker')
 */
class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Akun dinonaktifkan
        if (!$user->aktif) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Hubungi administrator.');
        }

        // Cek role
        if (!empty($roles) && !$user->hasRole($roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
