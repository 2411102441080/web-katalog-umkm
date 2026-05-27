<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Katalog Resmi UMKM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-700 antialiased">

    <nav class="navbar bg-base-100 border-b border-blue-100 px-4 md:px-12 sticky top-0 z-50 shadow-sm">
        <div class="flex-1">
            <a href="/" class="text-lg font-bold tracking-tight text-slate-800 uppercase">E-Katalog UMKM</a>
        </div>
        <div class="flex-none">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('admin.products.index') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-xl text-xs font-semibold px-4 shadow-sm">Dashboard Admin</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost text-slate-600 border border-slate-200 hover:bg-slate-50 btn-sm rounded-xl text-xs font-semibold px-4">Login Admin</a>
                @endauth
            @endif
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto p-6 md:p-12 w-full space-y-12">
        
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-800 md:text-4xl">Katalog Komoditas UMKM</h1>
            <p class="text-xs text-slate-500 font-medium leading-relaxed">Platform digital publikasi produk usaha mikro, kecil, dan menengah lokal guna memperluas jangkauan pasar ekosistem digital.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
            <div class="card bg-base-100 border border-blue-100 shadow-sm hover:shadow-md transition-all rounded-2xl overflow-hidden flex flex-col justify-between">
                
                <figure class="h-48 bg-slate-100 relative">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                    <span class="badge bg-blue-600 text-white border-none font-bold text-[9px] uppercase tracking-wider px-2.5 py-2 absolute top-3 right-3 shadow-sm">
                        {{ $product->category->nama_kategori }}
                    </span>
                </figure>

                <div class="p-4 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-1">
                        <span class="text-[9px] uppercase font-bold tracking-wider text-slate-400 block">
                            Toko: {{ $product->store->nama_toko }}
                        </span>
                        <h2 class="text-sm font-bold text-slate-800 line-clamp-1">
                            {{ $product->name }}
                        </h2>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="space-y-3">
                        <div class="text-base font-black text-blue-600 tracking-tight">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        
                        <a href="https://wa.me/{{ $product->store->whatsapp }}?text=Halo%20{{ urlencode($product->store->nama_toko) }},%20saya%20tertarik%20dengan%20produk%20*{{ urlencode($product->name) }}*%20yang%20tertera%20pada%20E-Katalog." 
                           target="_blank" 
                           class="btn bg-emerald-600 hover:bg-emerald-700 text-white border-none btn-sm w-full rounded-xl text-xs font-semibold tracking-wide shadow-sm">
                           Hubungi Penjual
                        </a>
                    </div>
                </div>

            </div>
            @empty
            <div class="col-span-full py-16 bg-blue-50/30 rounded-2xl border border-dashed border-blue-200 text-center">
                <p class="text-xs font-medium text-slate-400 italic">Belum ada data komoditas produk yang terdaftar saat ini.</p>
            </div>
            @endforelse
        </div>

    </main>

    <footer class="footer footer-center p-4 bg-base-100 text-slate-400 border-t border-blue-100 text-[10px] font-semibold uppercase tracking-wider">
        <div>
            <p>© 2026 Proyek Web E-Katalog - Universitas Muhammadiyah Kalimantan Timur</p>
        </div>
    </footer>

</body>
</html>