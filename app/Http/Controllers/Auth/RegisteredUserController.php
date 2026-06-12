<?php

namespace App\Http\Controllers\Auth;

use App\Models\Store;
use App\Http\Controllers\Controller;
use App\Models\User;
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
    use App\Models\Store; // Pastikan Rani menambahkan import ini di bagian atas file

public function store(Request $request): RedirectResponse
{
    // 1. Validasi input akun sekaligus input toko awal
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'nama_toko' => ['required', 'string', 'max:255'], // Tambahan input toko
        'whatsapp' => ['required', 'string', 'max:20'],    // Tambahan input toko
        'alamat' => ['required', 'string'],                // Tambahan input toko
    ]);

    // 2. Bersihkan otomatis format nomor WhatsApp (logika kita kemarin)
    $nomor = preg_replace('/[^0-9]/', '', $request->whatsapp);
    if (str_starts_with($nomor, '0')) {
        $nomor = '62' . substr($nomor, 1);
    }

    // 3. Simpan data user baru sebagai 'umkm'
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'umkm', // Otomatis diset sebagai pelaku UMKM
    ]);

    // 4. Simpan data toko miliknya dengan status 'pending'
    Store::create([
        'user_id' => $user->id,
        'nama_toko' => $request->nama_toko,
        'whatsapp' => $nomor,
        'alamat' => $request->alamat,
        'status' => 'pending', // Menunggu validasi admin utama
    ]);

    event(new Registered($user));

    Auth::login($user);

    // 5. Lempar ke halaman utama dashboard (nanti kita batasi lewat middleware)
    return redirect(route('admin.products.index', absolute: false));
}
}
