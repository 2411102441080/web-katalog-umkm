<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua produk beserta data relasi kategori dan tokonya
        $products = Product::with(['category', 'store'])->latest()->get();
        
        // Melempar data ke halaman katalog publik
        return view('home', compact('products'));
    }
}   