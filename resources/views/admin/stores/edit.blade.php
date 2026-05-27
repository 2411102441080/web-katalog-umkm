@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="bg-base-100 p-6 rounded-2xl border border-blue-100 shadow-sm">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Perbarui Informasi Toko</h1>
            <p class="text-xs text-slate-500 mt-1">Lakukan perubahan pada data identitas UMKM yang terpilih.</p>
        </div>

        <form action="{{ route('admin.stores.update', $store->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nama Toko</span></label>
                <input type="text" name="nama_toko" value="{{ $store->nama_toko }}" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nomor WhatsApp</span></label>
                <input type="text" name="whatsapp" value="{{ $store->whatsapp }}" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400" required />
            </div>
            <div class="form-control">
    <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Alamat Toko</span></label>
    <textarea name="alamat" class="textarea textarea-bordered border-blue-100 h-20 text-xs rounded-lg text-slate-700 focus:outline-blue-400" required>{{ $store->alamat }}</textarea>
</div>

            <div class="flex gap-2 pt-4 border-t border-slate-50">
                <a href="{{ route('admin.stores.index') }}" class="btn btn-ghost border border-slate-200 btn-sm flex-1 rounded-xl text-xs">Batal</a>
                <button type="submit" class="btn bg-amber-500 hover:bg-amber-600 text-white border-none btn-sm flex-1 rounded-xl text-xs shadow-sm">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>
@endsection