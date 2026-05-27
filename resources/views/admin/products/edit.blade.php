@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="bg-base-100 p-6 rounded-2xl border border-blue-100 shadow-sm">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Edit Data Komoditas</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui informasi pada data produk yang telah terdaftar dalam sistem.</p>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nama Entitas Toko</span></label>
                <select name="store_id" class="select select-bordered border-blue-100 select-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ $product->store_id == $store->id ? 'selected' : '' }}>
                            {{ $store->nama_toko }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Kategori Klasifikasi</span></label>
                <select name="category_id" class="select select-bordered border-blue-100 select-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nama Produk</span></label>
                <input type="text" name="name" value="{{ $product->name }}" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nominal Harga (Rp)</span></label>
                <input type="number" name="price" value="{{ $product->price }}" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Deskripsi Spesifikasi</span></label>
                <textarea name="description" class="textarea textarea-bordered border-blue-100 h-24 text-xs rounded-lg text-slate-700 focus:outline-blue-400" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Gambar Produk</span></label>
                <input type="file" name="image" class="file-input file-input-bordered border-blue-100 file-input-sm w-full rounded-lg text-slate-700 text-xs" accept="image/*" />
                
                <div class="mt-3 p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-3">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-14 h-14 object-cover rounded-lg border bg-white shadow-sm" alt="Preview" />
                    <div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">Berkas Saat Ini</div>
                        <div class="text-[9px] text-slate-400 font-mono mt-0.5">Biarkan kosong jika tidak ingin mengubah gambar</div>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 pt-4 border-t border-slate-50">
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost border border-slate-200 btn-sm flex-1 rounded-xl text-xs">Batal</a>
                <button type="submit" class="btn bg-amber-500 hover:bg-amber-600 text-white border-none btn-sm flex-1 rounded-xl text-xs shadow-sm">Perbarui Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection