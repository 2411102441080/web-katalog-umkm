<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['store', 'category'])->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $stores = Store::all();
        $categories = Category::all();
        return view('admin.products.create', compact('stores', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'store_id' => $request->store_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    public function edit($id)
{
    $product = Product::findOrFail($id);
    $stores = Store::all();
    $categories = Category::all();
    return view('admin.products.edit', compact('product', 'stores', 'categories'));
}

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'store_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // boleh kosong saat edit
        ]);

        // Jika admin mengunggah foto baru
        if ($request->hasFile('image')) {
            // Hapus foto lama dari storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan foto baru
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'store_id' => $request->store_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $product->image,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}