<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AdminStoreController extends Controller
{
    public function index()
    {
        $stores = Store::latest()->get();
        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nama_toko' => 'required|string|max:255',
        'whatsapp'  => 'required|string|max:20',
        'alamat'    => 'required|string',
    ]);

    $data = $request->all();
    
    // Bersihkan format nomor WhatsApp
    $nomor = preg_replace('/[^0-9]/', '', $data['whatsapp']); // hapus karakter selain angka
    if (str_starts_with($nomor, '0')) {
        $nomor = '62' . substr($nomor, 1);
    } elseif (str_starts_with($nomor, '62')) {
        $nomor = $nomor;
    }
    $data['whatsapp'] = $nomor;

    Store::create($data);

    return redirect()->route('admin.stores.index')->with('success', 'Data toko berhasil disimpan.');
}

    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'whatsapp'  => 'required|string|max:20',
            'alamat'    => 'required|string',
        ]);

        $data = $request->all();

        // Bersihkan format nomor WhatsApp
        $nomor = preg_replace('/[^0-9]/', '', $data['whatsapp']);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (str_starts_with($nomor, '62')) {
            $nomor = $nomor;
        }
        $data['whatsapp'] = $nomor;

        $store->update($data);

        return redirect()->route('admin.stores.index')->with('success', 'Data toko berhasil diperbarui.');
    }

    public function destroy(Store $store)
{
    // Ambil semua produk milik toko ini
    $products = $store->products;

    foreach ($products as $product) {
        // Hapus file fisik gambar dari folder storage agar tidak menimbun sampah file
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        // Hapus data produk dari database
        $product->delete();
    }

    // Terakhir, hapus entitas toko
    $store->delete();

    return redirect()->route('admin.stores.index')->with('success', 'Data toko dan seluruh produk di dalamnya berhasil dihapus.');
}
}