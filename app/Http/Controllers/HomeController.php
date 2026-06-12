<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Memuat relasi sekaligus mengunci agar HANYA mengambil produk dari toko yang berstatus 'active'
        $query = Product::with(['category', 'store'])->whereHas('store', function ($q) {
            $q->where('status', 'active');
        });

        // Filter pencarian nama produk
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->get();

        return view('home', compact('products', 'categories'));
    }
}