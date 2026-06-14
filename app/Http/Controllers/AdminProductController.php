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
            $storeId = auth()->user()->store ? auth()->user()->store->id : 0;
            $products = Product::where('store_id', $storeId)->latest()->get();
        } else {
            // JALUR ADMIN: Langsung ambil semua produk
            $products = Product::with(['store', 'category'])->latest()->get();
        }

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $user = auth()->user();
        
        // PROTEKSI: Tolak jika GUEST, atau jika UMKM tapi status tokonya BELUM aktif
        if ($user->role === 'guest' || ($user->role === 'umkm' && (!$user->store || $user->store->status !== 'active'))) {
            abort(403, 'Aksi ditolak. Akun Mitra UMKM Anda belum aktif atau ditangguhkan.');
        }

        $categories = Category::all();
        $stores = Store::where('status', 'active')->get();
        
        return view('admin.products.create', compact('categories', 'stores'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role === 'guest' || ($user->role === 'umkm' && (!$user->store || $user->store->status !== 'active'))) {
            abort(403, 'Aksi ditolak.');
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'store_id' => $user->role === 'admin' ? 'required|exists:stores,id' : 'nullable',
        ]);

        $data = $request->all();

        // Otomatis pasangkan store_id milik UMKM itu sendiri
        if ($user->role === 'umkm') {
            $data['store_id'] = $user->store->id;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk baru berhasil diterbitkan.');
    }

    public function edit(Product $product)
    {
        $user = auth()->user();

        // PROTEKSI: Hanya admin utama ATAU pemilik sah toko yang berstatus aktif yang bisa edit
        if ($user->role === 'umkm') {
            if (!$user->store || $user->store->status !== 'active' || $product->store_id !== $user->store->id) {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak memodifikasi produk ini.');
            }
        } elseif ($user->role !== 'admin') {
            abort(403);
        }

        $categories = Category::all();
        $stores = Store::where('status', 'active')->get();

        return view('admin.products.edit', compact('product', 'categories', 'stores'));
    }

    public function update(Request $request, Product $product)
    {
        $user = auth()->user();

        if ($user->role === 'umkm') {
            if (!$user->store || $user->store->status !== 'active' || $product->store_id !== $user->store->id) {
                abort(403, 'Akses ditolak.');
            }
        } elseif ($user->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'store_id' => $user->role === 'admin' ? 'required|exists:stores,id' : 'nullable',
        ]);

        $data = $request->all();

        if ($user->role === 'umkm') {
            $data['store_id'] = $user->store->id;
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
        $user = auth()->user();

        if ($user->role === 'umkm') {
            if (!$user->store || $user->store->status !== 'active' || $product->store_id !== $user->store->id) {
                abort(403, 'Akses ditolak.');
            }
        } elseif ($user->role !== 'admin') {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus dari katalog.');
    }
}