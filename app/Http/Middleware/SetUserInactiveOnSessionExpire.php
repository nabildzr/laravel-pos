<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetUserInactiveOnSessionExpire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (method_exists($request, 'session')) {
            if (!Auth::check() && $request->session()->has('user_was_active')) {
                // Session expired, set is_active to false
                $userId = $request->session()->get('user_was_active');
                User::where('id', $userId)->update(['is_active' => false]);
                $request->session()->forget('user_was_active');
            }
            
            if (Auth::check()) {
                // Simpan user id ke session untuk deteksi expired nanti
                $request->session()->put('user_was_active', Auth::id());
            }
        }


        return $next($request);
    }
}
