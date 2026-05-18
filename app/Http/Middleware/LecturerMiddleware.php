<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LecturerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'lecturer') {
            return $next($request);
        }elseif (Auth::check() && Auth::user()->role === 'nobody') {
            // logout the user if they have the 'nobody' role
            Auth::logout();
            return redirect()->route('login')->withErrors(['Your account has no role assigned. Please contact the administrator.']);
        }

        abort(403, 'Unauthorized access.');
    }
}
