<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MultiUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow only 'admin' and 'super_admin' roles
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
