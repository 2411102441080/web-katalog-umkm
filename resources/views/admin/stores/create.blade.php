@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="bg-base-100 p-6 rounded-2xl border border-blue-100 shadow-sm">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Registrasi Toko</h1>
            <p class="text-xs text-slate-500 mt-1">Lengkapi informasi di bawah untuk mendaftarkan unit UMKM baru.</p>
        </div>

        <form action="{{ route('admin.stores.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nama Resmi Toko</span></label>
                <input type="text" name="nama_toko" placeholder="Contoh: Toko Berkah Jaya" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Nomor WhatsApp</span></label>
                <input type="text" name="whatsapp" placeholder="Contoh: 628123456789" class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 focus:outline-blue-400" required />
                <p class="text-[10px] text-slate-400 mt-2 italic">Format wajib: Kode negara diikuti nomor tanpa spasi (Contoh: 628xxx).</p>
            </div>
            <div class="form-control">
    <label class="label"><span class="label-text font-semibold text-slate-600 text-xs">Alamat Toko</span></label>
    <textarea name="alamat" placeholder="Masukkan alamat lengkap UMKM" class="textarea textarea-bordered border-blue-100 h-20 text-xs rounded-lg text-slate-700 focus:outline-blue-400" required></textarea>
</div>

            <div class="flex gap-2 pt-4 border-t border-slate-50">
                <a href="{{ route('admin.stores.index') }}" class="btn btn-ghost border border-slate-200 btn-sm flex-1 rounded-xl text-xs">Batal</a>
                <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm flex-1 rounded-xl text-xs shadow-sm">Simpan Data Toko</button>
            </div>
        </form>
    </div>
</div>
@endsection