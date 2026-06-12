<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // =============== PROTEKSI STATUS UMKM ===============
        $user = auth()->user();
        
        // Jika yang login adalah UMKM dan status tokonya belum aktif
        if ($user->role === 'umkm' && $user->store && $user->store->status !== 'active') {
            
            // Ambil status toko untuk menentukan pesan hambatannya
            $status = $user->store->status;
            
            // Keluarkan kembali user dari sistem keamanan login
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Lempar kembali ke halaman login dengan pesan sesuai status toko
            if ($status === 'pending') {
                return redirect()->route('login')->with('status', 'Akun UMKM Anda sedang dalam proses validasi oleh Admin Utama. Mohon tunggu verifikasi.');
            } elseif ($status === 'rejected') {
                return redirect()->route('login')->with('status', 'Maaf, pengajuan pendaftaran mitra UMKM Anda ditolak oleh Admin Utama karena tidak memenuhi syarat.');
            }
        }
        // =====================================================

        return redirect()->intended(route('admin.products.index', absolute: false));
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
