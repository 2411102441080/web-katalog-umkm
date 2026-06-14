<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminStoreController extends Controller
{
    public function index(Request $request)
    {
        // 1. JALUR UMKM: Langsung arahkan ke halaman profil toko mereka sendiri
        if (auth()->user()->role === 'umkm') {
            $store = auth()->user()->store;
            return view('admin.stores.my_store', compact('store'));
        }

        // 2. JALUR ADMIN UTAMA: Memantau semua Pengguna beserta data Toko mereka
        $query = User::with('store');

        // Fitur Pencarian Global Admin
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('store', function($storeQuery) use ($searchTerm) {
                      $storeQuery->where('nama_toko', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $users = $query->latest()->get();

        return view('admin.stores.index', compact('users'));
    }

    // Fungsi khusus Admin Utama untuk memvalidasi status pendaftaran UMKM (Setujui / Tolak)
    public function updateStatus(Request $request, Store $store)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya Admin Utama yang berwenang memvalidasi mitra.');
        }

        $request->validate([
            'status' => 'required|in:active,rejected,pending'
        ]);

        $store->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status verifikasi mitra UMKM ' . $store->nama_toko . ' berhasil diperbarui.');
    }

    // Fungsi bagi UMKM untuk memperbarui data profil toko mereka sendiri via halaman my_store
    public function update(Request $request, Store $store)
    {
        // Proteksi: Akun UMKM dilarang keras mengedit data toko milik orang lain
        if (auth()->user()->role === 'umkm' && (!auth()->user()->store || $store->id !== auth()->user()->store->id)) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'whatsapp'  => 'required|string|max:20',
            'alamat'    => 'required|string',
        ]);

        $data = $request->all();

        // Pembersihan otomatis format nomor WhatsApp murni angka
        $nomor = preg_replace('/[^0-9]/', '', $data['whatsapp']);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }
        $data['whatsapp'] = $nomor;

        $store->update($data);

        return redirect()->back()->with('success', 'Informasi profil toko UMKM berhasil diperbarui.');
    }

    // Fungsi Hapus Fleksibel: Menangani hapus Mitra UMKM maupun User biasa (Guest)
    public function destroy(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Tindakan ini memerlukan hak akses Admin Utama.');
        }

        // Jalur A: Jika menghapus Pengguna Biasa / Guest (Tanpa entitas toko)
        if ($id == 0 && $request->has('user_id')) {
            $user = User::findOrFail($request->user_id);
            $user->delete();
            
            return redirect()->route('admin.stores.index')->with('success', 'Akun pengguna biasa berhasil dihapus dari sistem.');
        }

        // Jalur B: Jika menghapus akun UMKM (Menghapus Toko, User, dan Produk secara Cascading)
        $store = Store::findOrFail($id);

        // Bersihkan semua file gambar produk milik toko ini di Storage internal
        $products = $store->products;
        foreach ($products as $product) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
        }

        // Hapus akun pendaftarnya (User)
        if ($store->user) {
            $store->user->delete();
        }

        // Hapus entitas tokonya
        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Toko UMKM dan seluruh data pengguna terkait berhasil dibersihkan dari sistem.');
    }
}