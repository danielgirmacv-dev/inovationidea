<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: Route::middleware('role:admin') or Route::middleware('role:reviewer')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        foreach ($roles as $role) {
            if ($role === 'reviewer' && $request->user()->isReviewer()) {
                return $next($request);
            }
            if ($role === 'admin' && $request->user()->isAdmin()) {
                return $next($request);
            }
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'You are not authorized to access this area.');
    }
}
