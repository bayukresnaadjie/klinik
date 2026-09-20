<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Jika user sudah login dan coba akses halaman guest (login, register),
     * redirect ke dashboard sesuai role.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect($this->redirectTo());
            }
        }

        return $next($request);
    }

    /**
     * Tentukan URL redirect berdasarkan role user yang sedang login.
     */
    protected function redirectTo(): string
    {
        return match (Auth::user()?->role) {
            'manajer' => route('manager.dashboard'),
            'kasir'   => route('kasir.dashboard'),
            default   => route('dashboard'),
        };
    }
}
