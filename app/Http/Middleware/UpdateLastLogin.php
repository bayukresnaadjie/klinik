<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Catat waktu login terakhir setiap kali user melakukan request.
 * Daftarkan sebagai 'web' middleware group di bootstrap/app.php (Laravel 11)
 * atau di Kernel.php $middlewareGroups (Laravel 10 ke bawah).
 */
class UpdateLastLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->last_login_at?->diffInMinutes(now()) > 5) {
            auth()->user()->update(['last_login_at' => now()]);
        }

        return $next($request);
    }
}
