@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-base-100 p-6 rounded-2xl border border-blue-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">Manajemen Produk</h1>
            <p class="text-xs text-slate-500 mt-1">Halaman pengelolaan data komoditas UMKM pada sistem e-katalog.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none rounded-xl shadow-sm px-5 w-full sm:w-auto text-xs">
            Tambah Produk
        </a>
    </div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 flex flex-col justify-center">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Jumlah Produk</span>
            <span class="text-2xl font-bold text-slate-800 mt-1">{{ $products->count() }} Item</span>
        </div>
        <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 flex flex-col justify-center">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Jumlah Toko</span>
            <span class="text-2xl font-bold text-blue-600 mt-1">{{ $products->pluck('store_id')->unique()->count() }} UMKM</span>
        </div>
    </div>

    <div class="card bg-base-100 border border-blue-100 shadow-sm overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="table table-md w-full">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-blue-100 text-xs">
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Toko Asal</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-blue-50/20 transition-colors text-slate-700 text-xs">
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-11 h-11 bg-slate-100">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $product->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-mono mt-0.5">PRD-{{ 1000 + $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-md border border-blue-100 uppercase tracking-tight">
                                {{ $product->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="font-medium text-slate-600">
                            {{ $product->store->nama_toko }}
                        </td>
                        <td class="font-bold text-slate-800">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <div class="inline-flex rounded-lg border border-slate-200 bg-slate-50 p-1 gap-1">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-ghost btn-xs rounded-md hover:bg-amber-500 hover:text-white font-medium px-2.5">
                                    Edit
                                </a>
                                <div class="w-[1px] h-3 bg-slate-200 self-center"></div>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus data secara permanen?')" class="m-0 p-0 inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-xs rounded-md hover:bg-rose-600 hover:text-white font-medium px-2.5">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-slate-400 italic">
                            Belum ada data komoditas yang terdaftar dalam database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="text-center py-2">
        <p class="text-[9px] text-slate-400 uppercase tracking-widest font-semibold">E-Katalog UMKM v1.0</p>
    </div>
</div>
@endsection