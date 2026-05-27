@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="bg-base-100 p-6 rounded-2xl border border-blue-100 shadow-sm">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Form Input Komoditas</h1>
            <p class="text-xs text-slate-500 mt-1">Lengkapi formulir berikut untuk menambahkan produk baru ke dalam database katalog.</p>
        </div>

        @if($errors->any())
            <div class="alert bg-rose-50 text-rose-700 border border-rose-200 shadow-sm mb-4 text-xs rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nama Entitas Toko</span></label>
                <select name="store_id" class="select select-bordered border-blue-100 select-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required>
                    <option value="" disabled selected>Pilih Toko Asal</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->nama_toko }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Kategori Klasifikasi</span></label>
                <select name="category_id" class="select select-bordered border-blue-100 select-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nama Produk</span></label>
                <input type="text" name="name" placeholder="Masukkan nama komoditas" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nominal Harga (Rp)</span></label>
                <input type="number" name="price" placeholder="Contoh: 150000" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400 text-xs" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Deskripsi Spesifikasi Produk</span></label>
                <textarea name="description" placeholder="Tuliskan spesifikasi lengkap, ukuran, atau keterangan produk" class="textarea textarea-bordered border-blue-100 h-24 text-xs rounded-lg text-slate-700 focus:outline-blue-400" required></textarea>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">File Dokumentasi Gambar</span></label>
                <input type="file" name="image" class="file-input file-input-bordered border-blue-100 file-input-sm w-full rounded-lg text-slate-700 text-xs" accept="image/*" required />
                <span class="text-[10px] text-slate-400 mt-1 italic">Format file yang didukung: .png, .jpg, .jpeg (Maksimal 2 MB).</span>
            </div>

            <div class="flex gap-2 pt-4 border-t border-slate-50">
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost border border-slate-200 btn-sm flex-1 rounded-xl text-xs">Batal</a>
                <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm flex-1 rounded-xl text-xs shadow-sm">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection