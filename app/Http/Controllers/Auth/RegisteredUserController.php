<?php

namespace App\Http\Controllers\Auth;

use App\Models\Store;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input akun sekaligus input toko awal
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama_toko' => ['required', 'string', 'max:255'], 
            'whatsapp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],    
            'alamat' => ['required', 'string'],                
        ]);

        // 2. Bersihkan otomatis format nomor WhatsApp
        $nomor = preg_replace('/[^0-9]/', '', $request->whatsapp);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        // 3. Simpan data user baru sebagai 'umkm'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'umkm', 
        ]);

        // 4. Simpan data toko miliknya dengan status 'pending'
        Store::create([
            'user_id' => $user->id,
            'nama_toko' => $request->nama_toko,
            'whatsapp' => $nomor,
            'alamat' => $request->alamat,
            'status' => 'pending', 
        ]);

        event(new Registered($user));

        // PERBAIKAN KEAMANAN: Membatalkan login otomatis bawaan Laravel Breeze
        // Sesi langsung diarahkan kembali ke form login dengan pesan flash info peninjauan.
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun dan toko Anda saat ini sedang dalam proses peninjauan oleh Admin Utama. Silakan coba masuk setelah divalidasi.');
    }
}