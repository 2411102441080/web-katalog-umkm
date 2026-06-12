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
        if (!auth()->check() || auth()->user()->role !== 'umkm') {
            return redirect('/')->with('error', 'Akses khusus pelaku UMKM.');
        }

        // TAMBAHAN: Jika toko masih pending, kunci aksesnya dan beri peringatan
        if (auth()->user()->store->status === 'pending') {
            auth()->logout(); // Keluarkan akun otomatis
            return redirect('/login')->with('status', 'Akun UMKM Anda sedang dalam proses validasi oleh Admin Utama. Mohon tunggu.');
        }

        return $next($request);
    }
}
