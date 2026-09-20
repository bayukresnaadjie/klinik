<?php

namespace App\Providers;

use App\Models\ApprovalRequest;
use App\Policies\ApprovalRequestPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

   public function boot(): void
{
    \Carbon\Carbon::setLocale('id');
    Paginator::useBootstrapFive();
    Gate::policy(ApprovalRequest::class, ApprovalRequestPolicy::class);
    $this->configureRateLimiting();

    // ── HTTPS enforcement (production only) ──
   if ($this->app->environment('production')) {
    URL::forceScheme('https');
}
}

    protected function configureRateLimiting(): void
    {
        // ── Login form ──
        RateLimiter::for('login', function (Request $request) {
            return [
                // Maks 5x per email+IP per menit
                Limit::perMinute(5)
                    ->by(strtolower($request->input('email', '')) . '|' . $request->ip())
                    ->response(function () {
                        return back()->withErrors([
                            'email' => 'Terlalu banyak percobaan. Coba lagi dalam beberapa menit.',
                        ]);
                    }),
                // Maks 10x per IP per menit
                Limit::perMinute(10)
                    ->by($request->ip())
                    ->response(function () {
                        return back()->withErrors([
                            'email' => 'Terlalu banyak percobaan dari jaringan ini. Coba lagi nanti.',
                        ]);
                    }),
            ];
        });

        // ── SSO endpoint ──
        RateLimiter::for('sso', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())
                ->response(fn () => abort(429, 'Terlalu banyak percobaan SSO.'));
        });
    }
}
