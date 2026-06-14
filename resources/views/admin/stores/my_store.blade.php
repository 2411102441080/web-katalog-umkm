@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-800 uppercase">Profil Toko Anda</h1>
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Manajemen informasi badan usaha mitra</p>
    </div>

    @if($store)
        <div class="border rounded-2xl p-4 flex justify-between items-center bg-white border-blue-100 shadow-xs">
            <div class="space-y-0.5">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Status Verifikasi Sistem</span>
                <div class="text-xs font-bold text-slate-700">Akun Anda saat ini berstatus:</div>
            </div>
            <div>
                @if($store->status === 'active')
                    <span class="px-3 py-1 text-xs font-black uppercase rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">Mitra Aktif</span>
                @elseif($store->status === 'rejected')
                    <span class="px-3 py-1 text-xs font-black uppercase rounded-full bg-rose-50 text-rose-700 border border-rose-200">Pendaftaran Ditolak</span>
                @else
                    <span class="px-3 py-1 text-xs font-black uppercase rounded-full bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">Pending Review</span>
                @endif
            </div>
        </div>

        <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-xs">
            <form action="{{ route('admin.stores.update', $store->id) }}" method="POST" class="space-y-4 m-0 p-0">
                @csrf
                @method('PUT')

                <div class="form-control w-full">
                    <label class="label pb-1" for="nama_toko"><span class="label-text font-bold text-slate-600 text-xs">Nama Toko UMKM</span></label>
                    <input id="nama_toko" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400" type="text" name="nama_toko" value="{{ old('nama_toko', $store->nama_toko) }}" required />
                </div>

                <div class="form-control w-full">
                    <label class="label pb-1" for="whatsapp"><span class="label-text font-bold text-slate-600 text-xs">Nomor WhatsApp Toko</span></label>
                    <input id="whatsapp" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400" type="text" name="whatsapp" value="{{ old('whatsapp', $store->whatsapp) }}" required />
                </div>

                <div class="form-control w-full">
                    <label class="label pb-1" for="alamat"><span class="label-text font-bold text-slate-600 text-xs">Alamat Operasional Fisik</span></label>
                    <textarea id="alamat" rows="3" class="textarea textarea-bordered border-blue-100 w-full rounded-xl text-slate-700 text-xs focus:outline-blue-400 p-2.5 min-h-[80px]" name="alamat" required>{{ old('alamat', $store->alamat) }}</textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm w-full h-9 rounded-xl text-xs font-bold tracking-wide uppercase shadow-xs">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="alert bg-amber-50 text-amber-700 border border-amber-200 rounded-2xl p-4 text-xs font-semibold">
            Akun Anda belum terdaftar atau tidak memiliki entitas data mitra UMKM dalam sistem database.
        </div>
    @endif
</div>
@endsection