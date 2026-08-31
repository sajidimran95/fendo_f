<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    protected function configureRateLimiting(): void
    {
        // Strict: 5 attempts/min keyed by email (login, OTP verify)
        RateLimiter::for('auth-strict', function (Request $request) {
            $key = strtolower($request->input('email', $request->ip()));
            return Limit::perMinute(5)->by($key)->response(function () {
                return response()->json([
                    'status'  => false,
                    'message' => 'Too many attempts. Please wait 1 minute before trying again.',
                ], 429);
            });
        });

        // Standard: 10 attempts/min per IP (register, resend-otp, etc.)
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip())->response(function () {
                return response()->json([
                    'status'  => false,
                    'message' => 'Too many requests. Please slow down.',
                ], 429);
            });
        });

        // General API: 120/min for authenticated, 60/min for guests
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(120)->by($request->user()->id)
                : Limit::perMinute(60)->by($request->ip());
        });
    }
}
