@extends('layouts.app')

@section('content')
<div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-xs max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-blue-50">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">Kelola Pengguna & Kemitraan</h1>
            <p class="text-[10px] text-slate-400 tracking-wider mt-0.5">Validasi Hak Akses Sistem dan Status Lapak UMKM</p>
        </div>
        
        <form action="{{ route('admin.stores.index') }}" method="GET" class="w-full sm:w-auto flex items-center gap-2 m-0 p-0">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau toko..." class="input input-bordered border-blue-100 input-sm w-full sm:w-60 h-9 rounded-xl text-xs text-slate-700 focus:outline-blue-400" />
            <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm h-7 px-4 rounded-xl text-xs font-bold tracking-wide shrink-0">
                Cari
            </button>
        </form>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="table w-full text-xs text-left text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase tracking-wider text-[10px] border-b border-blue-50">
                <tr>
                    <th class="p-3">Nama & Alamat Email</th>
                    <th class="p-3">Hak Akses (Role)</th>
                    <th class="p-3">Nama Toko UMKM</th>
                    <th class="p-3">Status Lapak</th>
                    <th class="p-3 text-center">Aksi Verifikasi Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-3">
                        <div class="font-bold text-slate-800">{{ $user->name }}</div>
                        <div class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $user->email }}</div>
                    </td>
                    
                    <td class="p-3">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider font-mono
                            {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 
                               ($user->role === 'umkm' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-100 text-slate-600') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    
                    <td class="p-3 font-semibold text-slate-700">
                        {{ $user->store ? $user->store->nama_toko : '-' }}
                    </td>
                    
                    <td class="p-3">
                        @if($user->store)
                            @if($user->store->status === 'pending')
                                <span class="px-2 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-bold text-[11px] animate-pulse">Pending Review</span>
                            @elseif($user->store->status === 'active')
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-bold text-[11px]">Disetujui</span>
                            @else
                                <span class="px-2 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg font-bold text-[11px]">Ditolak</span>
                            @endif
                        @else
                            <span class="text-slate-400 italic text-[11px]">Tidak Buka Lapak</span>
                        @endif
                    </td>                
                    <td class="p-3 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            
                            @if($user->store)
                                <form action="{{ route('admin.stores.updateStatus', $user->store->id) }}" method="POST" class="inline m-0 p-0">
                                    @csrf
                                    @method('PATCH')

                                    @if($user->store->status !== 'active')
                                        <button type="submit" name="status" value="active" class="px-2.5 py-0.5 text-[10px] btn btn-xs bg-emerald-600 hover:bg-emerald-700 text-white border-none rounded-lg font-bold">Setujui</button>
                                    @endif

                                    @if($user->store->status !== 'rejected')
                                        <button type="submit" name="status" value="rejected" class="px-2.5 py-0.5 text-[10px] btn btn-xs bg-amber-500 hover:bg-amber-600 text-white border-none rounded-lg font-bold">Tolak</button>
                                    @endif
                                </form>
                            @endif
                            @if($user->role !== 'admin')
                                <form action="{{ $user->store ? route('admin.stores.destroy', $user->store->id) : route('admin.stores.destroy', ['store' => 0, 'user_id' => $user->id]) }}" 
                                    method="POST" 
                                    class="form-delete inline m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete px-2.5 py-0.5 text-[10px] btn btn-xs bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-lg font-bold">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-400 font-mono text-[10px] italic">- Utama -</span>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-slate-400 font-medium italic">
                        Tidak ditemukan data pengguna atau toko yang cocok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection