<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin E-Katalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col md:flex-row text-slate-700 antialiased">

    <div class="w-full md:w-64 bg-base-100 border-r border-blue-100 p-4 space-y-2 flex flex-col justify-between">
        <div class="space-y-4">
            <div class="px-4 py-2">
                <h2 class="text-lg font-bold tracking-tight text-slate-800">E-Katalog UMKM</h2>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mt-0.5">Panel Manajemen</p>
            </div>
            
            <div class="h-[1px] bg-blue-100 my-1"></div>
            
            <ul class="menu menu-md w-full rounded-none p-0 gap-1">
                <li>
                    <a href="{{ route('admin.products.index') }}" class="rounded-xl px-4 py-2.5 text-xs font-semibold tracking-wide transition-all {{ request()->routeIs('admin.products.index') ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'text-slate-600 hover:bg-slate-50' }}">
                        Kelola Barang
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stores.index') }}" class="rounded-xl px-4 py-2.5 text-xs font-semibold tracking-wide transition-all {{ request()->routeIs('admin.stores.index') ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'text-slate-600 hover:bg-slate-50' }}">
                        Kelola Toko
                    </a>
                </li>

            </ul>
        </div>
        
        <div class="space-y-2">
            <div class="h-[1px] bg-blue-100 my-1"></div>
            <a href="{{ route('home') }}" class="btn btn-ghost hover:bg-slate-50 hover:text-blue-700 border border-slate-200 hover:border-blue-300 btn-sm w-full rounded-xl text-xs font-semibold tracking-wide transition-colors">
                Kunjungi Situs
            </a>
            <form method="POST" action="{{ route('logout') }}" class="w-full m-0 p-0">
                @csrf
                <button type="submit" class="btn btn-ghost hover:bg-rose-50 hover:text-rose-600 border border-slate-200 hover:border-rose-200 btn-sm w-full rounded-xl text-xs font-semibold tracking-wide transition-colors" onclick="event.preventDefault(); this.closest('form').submit();">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>

    <div class="flex-1 p-6 md:p-8 overflow-y-auto">
        @if(session('success'))
            <div class="alert bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm mb-6 max-w-6xl mx-auto rounded-xl py-3 text-xs font-semibold">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>