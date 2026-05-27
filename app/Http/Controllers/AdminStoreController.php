<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

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

        Store::create($request->all());

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

        $store->update($request->all());

        return redirect()->route('admin.stores.index')->with('success', 'Data toko berhasil diperbarui.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Data toko berhasil dihapus.');
    }
}