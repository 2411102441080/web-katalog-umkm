@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-800 uppercase">Validasi Mitra UMKM</h1>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kelola izin akses dan verifikasi toko</p>
        </div>
        
        <form action="{{ route('admin.stores.index') }}" method="GET" class="w-full sm:w-auto flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko..." class="input input-bordered border-blue-100 input-sm w-full sm:w-60 rounded-xl text-slate-700 text-xs focus:outline-blue-400 h-9" />
            <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-xl text-xs px-4 h-9">Cari</button>
        </form>
    </div>

    <div class="bg-white border border-blue-100 rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-slate-700 text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-blue-100 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Nama Toko</th>
                        <th class="py-3 px-4 font-bold">Pemilik / Email</th>
                        <th class="py-3 px-4 font-bold">WhatsApp</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold text-center">Aksi Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stores as $store)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $store->nama_toko }}
                                <div class="text-[10px] text-slate-400 font-normal max-w-xs truncate mt-0.5" title="{{ $store->alamat }}">{{ $store->alamat }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium">
                                {{ $store->user->name ?? 'Tidak Ada' }}
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $store->user->email ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-blue-600">62{{ substr($store->whatsapp, 2) }}</td>
                            <td class="py-3.5 px-4">
                                @if($store->status === 'active')
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                                @elseif($store->status === 'rejected')
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase rounded-full bg-rose-50 text-rose-700 border border-rose-200">Ditolak</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase rounded-full bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">Pending</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <form action="{{ route('admin.stores.updateStatus', $store->id) }}" method="POST" class="inline flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        @if($store->status !== 'active')
                                            <button type="submit" name="status" value="active" class="px-2.5 py-0.5 text-[10px] btn btn-xs bg-emerald-600 hover:bg-emerald-700 text-white border-none rounded-lg font-bold">Setujui</button>
                                        @endif
                                        @if($store->status !== 'rejected')
                                            <button type="submit" name="status" value="rejected" class="px-2.5 py-0.5 text-[10px] btn btn-xs bg-amber-500 hover:bg-amber-600 text-white border-none rounded-lg font-bold">Tolak</button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" onsubmit="return confirm('Hapus toko ini? Semua produk di dalamnya akan ikut terhapus permanen.');" class="inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-0.5 text-[10px] btn btn-xs bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-lg font-bold">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-400 font-medium">Belum ada mitra UMKM yang mendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection