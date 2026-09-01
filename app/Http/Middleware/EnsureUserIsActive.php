<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->isActive()) {
            $user->tokens()->delete();
            $message = $user->isBanned()
                ? 'Your account has been banned. Contact support.'
                : 'Your account has been suspended. Contact support.';

            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => null,
            ], 403);
        }

        return $next($request);
    }
}
