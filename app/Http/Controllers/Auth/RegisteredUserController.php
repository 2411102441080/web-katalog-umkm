<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // 1. Aturan validasi dasar untuk akun Pengguna
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:umkm,guest'], // Validasi pilihan role baru
        ];

        // 2. Validasi tambahan bersyarat: Jika role adalah UMKM, form toko WAJIB diisi
        if ($request->role === 'umkm') {
            $rules['nama_toko'] = ['required', 'string', 'max:255'];
            $rules['whatsapp'] = ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'];
            $rules['alamat'] = ['required', 'string'];
        }

        $request->validate($rules);

        // 3. Simpan data user baru dengan role dinamis ('umkm' atau 'guest')
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
        ]);

        event(new Registered($user));

        // 4. Kondisional Berdasarkan Role yang Dipilih
        if ($request->role === 'umkm') {
            // Bersihkan format nomor WhatsApp murni angka
            $nomor = preg_replace('/[^0-9]/', '', $request->whatsapp);
            if (str_starts_with($nomor, '0')) {
                $nomor = '62' . substr($nomor, 1);
            }

            // Simpan data toko dengan status awal 'pending'
            Store::create([
                'user_id' => $user->id,
                'nama_toko' => $request->nama_toko,
                'whatsapp' => $nomor,
                'alamat' => $request->alamat,
                'status' => 'pending', 
            ]);
        }

        // 5. UTAMA: Otomatis loginkan user yang baru mendaftar (baik UMKM maupun Guest)
        Auth::login($user);

        // 6. Alihkan ke halaman tujuan sesuai rolenya
        if ($user->role === 'umkm') {
            // UMKM langsung masuk ke dashboard manajemen produk internal
            return redirect()->route('admin.products.index');
        }

        // Guest/Pembeli umum diarahkan ke halaman katalog depan
        return redirect()->route('home');
    }
}