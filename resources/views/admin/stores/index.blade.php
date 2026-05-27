@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-base-100 p-6 rounded-2xl border border-blue-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">Daftar Toko UMKM</h1>
            <p class="text-xs text-slate-500 mt-1">Halaman manajemen seluruh entitas toko yang terintegrasi dalam sistem.</p>
        </div>
        <a href="{{ route('admin.stores.create') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none rounded-xl shadow-sm px-5 w-full sm:w-auto text-xs">
            Registrasi Toko Baru
        </a>
    </div>

    <div class="card bg-base-100 border border-blue-100 shadow-sm overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="table table-md w-full">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-blue-100 text-xs">
                        <th class="py-4 px-6">Nama Toko</th>
                        <th>Nomor WhatsApp</th>
                        <th>Tanggal Registrasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stores as $store)
                    <tr class="hover:bg-blue-50/20 transition-colors text-slate-700 text-xs">
                        <td class="py-4 px-6 font-bold text-slate-800">
                            {{ $store->nama_toko }}
                        </td>
                        <td class="font-medium text-blue-600 uppercase">
                            {{ $store->whatsapp }}
                        </td>
                        <td class="text-slate-500">
                            {{ $store->created_at->format('d F Y') }}
                        </td>
                        <td class="text-center">
                            <div class="inline-flex rounded-lg border border-slate-200 bg-slate-50 p-1 gap-1">
                                <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-ghost btn-xs rounded-md hover:bg-amber-500 hover:text-white font-medium px-2.5">
                                    Edit
                                </a>
                                <div class="w-[1px] h-3 bg-slate-200 self-center"></div>
                                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" onsubmit="return confirm('Hapus data toko secara permanen?')" class="m-0 p-0 inline">
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
                        <td colspan="4" class="py-16 text-center text-slate-400 italic">
                            Belum ada entitas toko yang terdaftar dalam database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection