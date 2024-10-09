<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ParentMiddleware
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

            if ($user->role == 4) { // Role 4 is for parent
                // Check if the parent has children assigned
                if ($user->children()->count() > 0) {
                    return $next($request);
                } else {
                    // Logout and redirect if no child is assigned
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['error' => 'Access denied. No child is assigned to your account.']);
                }
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Access denied. You are not a parent.']);
            }
        } else {
            return redirect()->route('login');
        }
    }
}
