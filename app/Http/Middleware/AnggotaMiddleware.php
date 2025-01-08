<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        
        // Periksa apakah user sudah login dan memiliki role anggota
        if (Auth::check() && Auth::user()->role === 'anggota') {
            return $next($request);
        }

        // Redirect jika bukan anggota
        return redirect()->route('loginForm')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}