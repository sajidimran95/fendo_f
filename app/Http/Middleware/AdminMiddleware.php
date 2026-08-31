<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || (int) Auth::user()->is_admin !== 1) {
            Auth::logout();

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Access denied. Administrators only.']);
        }

        return $next($request);
    }
}
