<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
    
            if ($user->role == 1) { // Assuming role 1 is for admins
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Access denied. You are not an admin.']);
            }
        } else {
            return redirect()->route('login');
        }
    }
}
