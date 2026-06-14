@extends('layouts.app')

@section('content')
<div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-xs max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-blue-50">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">Daftar Produk Katalog</h1>
            <p class="text-[10px] text-slate-400 tracking-wider mt-0.5">Kelola data komoditas barang dagangan mitra UMKM</p>
        </div>
        
        @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'umkm' && auth()->user()->store && auth()->user()->store->status === 'active'))
            <a href="{{ route('admin.products.create') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm h-9 px-4 rounded-xl text-xs font-bold uppercase tracking-wide shrink-0">
                ➕ Tambah Produk Baru
            </a>
        @endif
    </div>

    <div class="overflow-x-auto w-full">
        <table class="table w-full text-xs text-left text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase tracking-wider text-[10px] border-b border-blue-50">
                <tr>
                    <th class="p-3 w-24">Foto</th>
                    <th class="p-3">Nama Produk</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Harga</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="p-3">Toko Pemilik</th>
                    @endif
                    <th class="p-3 text-center">Aksi Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-3">
                        <div class="avatar">
                            <div class="w-16 h-16 rounded-xl border border-slate-100 shadow-xs bg-slate-50 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-1" />
                                @else
                                    <span class="text-[10px] text-slate-400">No Image</span>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="p-3 font-bold text-slate-800">
                        {{ $product->name }}
                    </td>
                    
                    <td class="p-3">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md font-medium text-[11px]">
                            {{ $product->category ? $product->category->nama_kategori : 'Tanpa Kategori' }}
                        </span>
                    </td>

                    <td class="p-3 font-semibold text-slate-700 font-mono">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    @if(auth()->user()->role === 'admin')
                        <td class="p-3 font-medium text-blue-600">
                            {{ $product->store ? $product->store->nama_toko : 'Tanpa Toko' }}
                        </td>
                    @endif

                    <td class="p-3 text-center">
                        @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'umkm' && auth()->user()->store && auth()->user()->store->status === 'active' && $product->store_id === auth()->user()->store->id))
                            <div class="flex items-center justify-center gap-1.5">
                                
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="px-2.5 py-1 text-[10px] btn btn-xs bg-amber-500 hover:bg-amber-600 text-white border-none rounded-lg font-bold">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                      method="POST" 
                                      class="form-delete inline m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete px-2.5 py-0.5 text-[10px] btn btn-xs bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-lg font-bold">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        @else
                            <span class="text-slate-400 italic text-[11px] font-medium">Akses Dikunci</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="p-6 text-center text-slate-400 font-medium italic">
                        Belum ada data produk yang terdaftar di dalam katalog.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection