<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Redirect ke halaman sesuai role jika tidak punya akses.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            // Arahkan ke dashboard sesuai role masing-masing
            return match ($userRole) {
                'admin'   => redirect()->route('admin.dashboard')
                                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                'manager' => redirect()->route('manager.dashboard')
                                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                default   => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
