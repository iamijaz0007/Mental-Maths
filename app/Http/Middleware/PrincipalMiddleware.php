<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\School;

class PrincipalMiddleware
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

            // Check if the user is an admin
            if ($user->role == 1) {
                return $next($request);
            }

            // Check if the user is a principal and has a valid school_id
            if ($user->role == 2 && $user->school_id) {
                // Check if the school is active or pending
                $school = School::find($user->school_id);

                if ($school && ($school->status == 'active' || $school->status == 'pending')) {
                    return $next($request); // Allow access if the school is active or pending
                } else {
                    // Log out and redirect to login if the school is blocked or not found
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['error' => 'Access denied. Your school is blocked or inactive.']);
                }
            } else {
                // Log out and redirect to login if the role does not match or school_id is missing
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Access denied. Missing school association.']);
            }
        } else {
            // Redirect to login if the user is not authenticated
            return redirect()->route('login');
        }
    }
}
