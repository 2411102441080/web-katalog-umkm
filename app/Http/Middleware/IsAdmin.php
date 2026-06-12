<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login atau role-nya bukan admin, lempar kembali ke halaman utama
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses khusus Admin Utama.');
        }
        return $next($request);
    }
}
