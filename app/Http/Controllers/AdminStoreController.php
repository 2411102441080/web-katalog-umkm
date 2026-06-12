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
        $query = Store::with('user');

        // Jika UMKM yang membuka menu ini, langsung arahkan ke toko mereka sendiri (tidak melihat toko lain)
        if (auth()->user()->role === 'umkm') {
            $store = auth()->user()->store;
            return view('admin.stores.my_store', compact('store'));
        }

        // Jalur khusus Admin Utama: Bisa mencari nama toko dan melihat data validasi global
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_toko', 'like', '%' . $request->search . '%');
        }

        $stores = $query->latest()->get();

        return view('admin.stores.index', compact('stores'));
    }

    // Fungsi khusus Admin Utama untuk memvalidasi UMKM (Setujui / Tolak)
    public function updateStatus(Request $request, Store $store)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya Admin Utama yang berwenang memvalidasi mitra.');
        }

        $request->validate([
            'status' => 'required|in:active,rejected,pending'
        ]);

        $store->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status verifikasi mitra UMKM berhasil diperbarui.');
    }

    public function update(Request $request, Store $store)
    {
        // Proteksi: Akun UMKM dilarang mengedit data toko milik orang lain
        if (auth()->user()->role === 'umkm' && $store->id !== auth()->user()->store->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'whatsapp'  => 'required|string|max:20',
            'alamat'    => 'required|string',
        ]);

        $data = $request->all();

        // Pembersihan otomatis format nomor WhatsApp
        $nomor = preg_replace('/[^0-9]/', '', $data['whatsapp']);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }
        $data['whatsapp'] = $nomor;

        $store->update($data);

        return redirect()->back()->with('success', 'Informasi profil toko UMKM berhasil diperbarui.');
    }

    public function destroy(Store $store)
    {
        // Hanya Admin Utama yang berhak menghapus entitas toko atau memblokir barang ilegal
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Tindakan ini memerlukan hak akses Admin Utama.');
        }

        // Hapus massal seluruh produk dan berkas fisik gambar milik toko ini (Cascading Delete)
        $products = $store->products;
        foreach ($products as $product) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
        }

        // Hapus juga data user pendaftarnya agar sistem bersih
        if ($store->user) {
            $store->user->delete();
        }

        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Toko UMKM dan seluruh aset produk ilegal di dalamnya berhasil dibersihkan dari sistem.');
    }
}