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
    public function handle(Request $request, Closure $next): Response
        {
            // HANYA admin yang boleh lewat
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }

            abort(403, 'Halaman ini hanya khusus untuk Admin Utama.');
        }
}
