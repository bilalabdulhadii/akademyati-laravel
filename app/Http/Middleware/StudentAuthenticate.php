<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->hasRole('student')) {
            return $next($request);
        } elseif (Auth::user()->hasRole('admin') || Auth::user()->hasRole('instructor')) {
            return redirect()->route('dashboard');
        }

        // If the user is not a student
        return redirect()->route('home');
    }
}
