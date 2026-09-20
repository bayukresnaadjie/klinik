<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login & redirect sesuai role.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        auth()->user()->update(['last_login_at' => now()]);

        return redirect($this->redirectByRole());
    }

    /**
     * Logout & redirect ke login.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Tentukan URL tujuan berdasarkan role user yang login.
     */
    private function redirectByRole(): string
    {
        return match (Auth::user()->role) {
            'manajer'  => route('manager.dashboard'),
            'kasir'    => route('kasir.dashboard'),
            default    => route('dashboard'),
        };
    }
}
