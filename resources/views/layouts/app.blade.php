<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Manajemen E-Katalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 h-screen flex flex-col md:flex-row text-slate-700 antialiased overflow-hidden">

    <div class="w-full md:w-64 md:h-screen md:sticky md:top-0 bg-white border-r border-blue-100 p-4 space-y-2 flex flex-col justify-between z-20 shrink-0">
        <div class="space-y-4">
            <div class="px-4 py-2">
                <h2 class="text-lg font-bold tracking-tight text-slate-800">E-Katalog UMKM</h2>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mt-0.5">Panel Manajemen</p>
            </div>
            
            <div class="h-[1px] bg-blue-50 my-1"></div>
            
            <ul class="menu menu-md w-full rounded-none p-0 gap-1">
                <li>
                    <a href="{{ route('admin.products.index') }}" class="rounded-xl px-4 py-2.5 text-xs font-semibold tracking-wide transition-all {{ request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-700 border border-blue-100/50 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                        Kelola Barang
                    </a>
                </li>
                
                <li>
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.stores.index') : route('admin.stores.my_store') }}" class="rounded-xl px-4 py-2.5 text-xs font-semibold tracking-wide transition-all {{ (request()->routeIs('admin.stores.index') || request()->routeIs('admin.stores.my_store')) ? 'bg-blue-50 text-blue-700 border border-blue-100/50 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                        @if(auth()->user()->role === 'admin')
                            Kelola Toko
                        @else
                            Profil Toko
                        @endif
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="space-y-2">
            <div class="h-[1px] bg-blue-50 my-1"></div>
            
            <a href="{{ route('home') }}" class="btn btn-ghost hover:bg-slate-50 hover:text-blue-700 border border-slate-200 hover:border-blue-300 btn-sm w-full rounded-xl text-xs font-semibold tracking-wide transition-colors h-9">
                Kunjungi Situs
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="w-full m-0 p-0">
                @csrf
                <button type="submit" class="btn btn-ghost hover:bg-rose-50 hover:text-rose-600 border border-slate-200 hover:border-rose-200 btn-sm w-full rounded-xl text-xs font-semibold tracking-wide transition-colors h-9" onclick="event.preventDefault(); this.closest('form').submit();">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 h-full p-6 md:p-8 overflow-y-auto">
        @if(session('success'))
            <div class="alert bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm mb-6 max-w-6xl mx-auto rounded-xl py-3 text-xs font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>