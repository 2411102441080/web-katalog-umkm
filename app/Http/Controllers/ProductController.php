<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['store', 'category'])->get();
        return view('home', compact('products'));
    }
}