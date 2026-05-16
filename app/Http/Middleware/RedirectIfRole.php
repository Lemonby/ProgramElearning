<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if (isset($user->role) && $user->role === 'member') {
            return redirect()->route('dashboard.member');
        }

        if (isset($user->role) && $user->role === 'mentor') {
            return redirect()->route('dashboard.mentor');
        }

        return $next($request);
    }
}
