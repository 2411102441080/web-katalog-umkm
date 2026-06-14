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

        $user = auth()->user();
        
        // JALUR PENGALIHAN BERDASARKAN ROLE
        if ($user->role === 'guest') {
            // Jika pembeli biasa/guest, langsung arahkan ke katalog depan
            return redirect()->intended(route('home'));
        }

        // Jalur untuk UMKM (Pending/Active/Rejected) dan Admin Utama masuk ke Dashboard
        if ($user->role === 'umkm' && $user->store) {
            $status = $user->store->status;

            if ($status === 'pending') {
                return redirect()->route('admin.products.index')->with('info', 'Mode Pratinjau: Akun Toko Anda masih berstatus Pending. Anda belum dapat mengelola produk hingga disetujui Admin.');
            } elseif ($status === 'rejected') {
                return redirect()->route('admin.products.index')->with('info', 'Pemberitahuan: Pengajuan Toko Anda Ditolak oleh Admin. Hak pengelolaan produk dinonaktifkan.');
            }
        }

        // Kondisi jika akun aktif murni atau admin utama
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