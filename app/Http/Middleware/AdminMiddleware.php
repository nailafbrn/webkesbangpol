<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ini adalah cara pengecekan yang benar dan aman
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        return redirect('/home')->with('error', 'Anda tidak memiliki akses admin.');
    }
}