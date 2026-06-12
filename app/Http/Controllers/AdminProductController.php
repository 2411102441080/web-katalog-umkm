<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        // 1. CEK ROLE: Jika pelaku UMKM, batasi data produk milik tokonya sendiri
        if (auth()->user()->role === 'umkm') {
            if (!auth()->user()->store) {
                abort(403, 'Akun UMKM Anda belum memiliki entitas data Toko.');
            }
            $products = Product::where('store_id', auth()->user()->store->id)->latest()->get();
        } else {
            // 2. JALUR ADMIN: Langsung ambil semua produk tanpa memicu error "property id on null"
            $products = Product::with(['store', 'category'])->latest()->get();
        }

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        // Admin bisa memilih semua toko aktif, UMKM tidak perlu karena otomatis
        $stores = Store::where('status', 'active')->get();

        return view('admin.products.create', compact('categories', 'stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // Jika admin yang menambah, field store_id wajib dipilih dari dropdown
            'store_id' => auth()->user()->role === 'admin' ? 'required|exists:stores,id' : 'nullable',
        ]);

        $data = $request->all();

        // Otomatisasi store_id khusus untuk akun UMKM
        if (auth()->user()->role === 'umkm') {
            $data['store_id'] = auth()->user()->store->id;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk baru berhasil diterbitkan.');
    }

    public function edit(Product $product)
    {
        // Proteksi: Akun UMKM dilarang mengedit produk milik toko lain
        if (auth()->user()->role === 'umkm' && $product->store_id !== auth()->user()->store->id) {
            abort(403, 'Akses ditolak. Anda bukan pemilik sah produk ini.');
        }

        $categories = Category::all();
        $stores = Store::where('status', 'active')->get();

        return view('admin.products.edit', compact('product', 'categories', 'stores'));
    }

    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role === 'umkm' && $product->store_id !== auth()->user()->store->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'store_id' => auth()->user()->role === 'admin' ? 'required|exists:stores,id' : 'nullable',
        ]);

        $data = $request->all();

        if (auth()->user()->role === 'umkm') {
            $data['store_id'] = auth()->user()->store->id;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if (auth()->user()->role === 'umkm' && $product->store_id !== auth()->user()->store->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus dari katalog.');
    }
}