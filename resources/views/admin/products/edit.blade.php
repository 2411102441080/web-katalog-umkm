@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-800 uppercase">Ubah Data Produk</h1>
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Perbarui rincian informasi komoditas terpilih</p>
    </div>

    <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-xs">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 m-0 p-0">
            @csrf
            @method('PUT')

            @if(auth()->user()->role === 'admin')
                <div class="form-control w-full">
                    <label class="label pb-1" for="store_id">
                        <span class="label-text font-bold text-slate-600 text-xs">Pilih Toko Pemilik</span>
                    </label>
                    <select id="store_id" name="store_id" class="select select-bordered border-blue-100 select-sm w-full h-9 rounded-xl text-xs text-slate-700 focus:outline-blue-400" required>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>{{ $store->nama_toko }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('store_id'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('store_id') }}</div>
                    @endif
                </div>
            @endif

            <div class="form-control w-full">
                <label class="label pb-1" for="name">
                    <span class="label-text font-bold text-slate-600 text-xs">Nama Produk Komoditas</span>
                </label>
                <input id="name" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400" type="text" name="name" value="{{ old('name', $product->name) }}" required />
                @if($errors->has('name'))
                    <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label pb-1" for="category_id">
                        <span class="label-text font-bold text-slate-600 text-xs">Kategori Produk</span>
                    </label>
                    <select id="category_id" name="category_id" class="select select-bordered border-blue-100 select-sm w-full h-9 rounded-xl text-xs text-slate-700 focus:outline-blue-400" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category_id'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('category_id') }}</div>
                    @endif
                </div>

                <div class="form-control w-full">
                    <label class="label pb-1" for="price">
                        <span class="label-text font-bold text-slate-600 text-xs">Harga Jual (Rupiah)</span>
                    </label>
                    <input id="price" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400" type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" />
                    @if($errors->has('price'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('price') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-control w-full">
                <label class="label pb-1" for="description">
                    <span class="label-text font-bold text-slate-600 text-xs">Deskripsi Lengkap Produk</span>
                </label>
                <textarea id="description" rows="4" class="textarea textarea-bordered border-blue-100 w-full rounded-xl text-slate-700 text-xs focus:outline-blue-400 p-2.5 min-h-[100px]" name="description" required>{{ old('description', $product->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('description') }}</div>
                @endif
            </div>

            <div class="form-control w-full space-y-2">
                <label class="label pb-0" for="image">
                    <span class="label-text font-bold text-slate-600 text-xs">Ganti Foto Produk (Biarkan kosong jika tidak diubah)</span>
                </label>
                
                @if($product->image)
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-xl p-2.5 max-w-xs">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded-lg border border-slate-200" alt="Foto lama">
                        <span class="text-[10px] text-slate-400 font-semibold uppercase">Foto Aktif Saat Ini</span>
                    </div>
                @endif

                <input id="image" type="file" name="image" class="file-input file-input-bordered border-blue-100 file-input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400" accept="image/*" />
                @if($errors->has('image'))
                    <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('image') }}</div>
                @endif
            </div>

            <div class="pt-4 flex gap-2">
                <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm flex-1 h-9 rounded-xl text-xs font-bold uppercase tracking-wide shadow-xs">
                    Perbarui Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost border border-slate-200 btn-sm h-9 rounded-xl text-xs font-semibold tracking-wide">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection