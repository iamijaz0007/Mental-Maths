<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
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
    
            // Only enforce the school_id and school status checks for students
            if ($user->role == 3 && $user->school_id && $user->school->status !== 'blocked') {
                return $next($request);
            } elseif ($user->role == 1) {
                // Allow admins to pass through student middleware without restrictions
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Access denied. Missing school association or school is blocked.']);
            }
        } else {
            return redirect()->route('login');
        }
    }
}
