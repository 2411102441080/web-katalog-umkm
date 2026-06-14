<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
            $categories = Category::all();
            $storesCount = Store::where('status', 'active')->count();

            // =============== VALIDASI FILTER HARGA ===============
            $request->validate([
                'min_price' => 'nullable|numeric|min:0',
                'max_price' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    // Aturan agar harga maksimal tidak boleh lebih kecil dari harga minimal
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->filled('min_price') && $value < $request->min_price) {
                            $fail('Angka maksimum tidak boleh lebih kecil dari angka minimum.');
                        }
                    },
                ],
            ]);
            // =====================================================

            $query = Product::with(['category', 'store'])->whereHas('store', function ($q) {
                $q->where('status', 'active');
            });

            // Filter pencarian nama produk / UMKM
            if ($request->has('search') && $request->search != '') {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('store', function ($storeQuery) use ($searchTerm) {
                        $storeQuery->where('nama_toko', 'like', '%' . $searchTerm . '%');
                    });
                });
            }

            // Filter Kategori
            if ($request->has('category') && $request->category != '') {
                $query->where('category_id', $request->category);
            }

            // Filter Harga Minimum
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }

            // Filter Harga Maksimum
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            $products = $query->latest()->get();

            return view('home', compact('products', 'categories', 'storesCount'));
    }
    public function storeDetail($slug)
    {
        // Menggunakan where() untuk mencocokkan slug/nama unik toko secara aman
        $store = Store::where('nama_toko', '=', urldecode($slug))->firstOrFail();
        
        // Ambil produk berdasarkan store_id dari toko yang aman tadi
        $products = Product::where('store_id', $store->id)->latest()->get();
        
        $categories = Category::all();
        $storesCount = Store::count();

        return view('store_detail', compact('store', 'products', 'categories', 'storesCount'));
    }
}