<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('front.welcome');
        }

        $user = Auth::user();

        if (! $user->isActive()) {
            Auth::logout();

            return redirect()->route('front.welcome')->withErrors(['phone' => 'Your account is suspended.']);
        }

        if (! $user->profile_completed && ! $request->routeIs('front.onboarding*')) {
            return redirect()->route('front.onboarding');
        }

        return $next($request);
    }
}
