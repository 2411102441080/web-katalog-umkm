<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUMKM
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Selama dia login dan rolenya adalah 'admin' atau 'umkm', BERIKAN AKSES MASUK
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'umkm')) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        return redirect()->route('home')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}
