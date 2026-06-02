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
            @auth
                <a href="{{ route('admin.products.index') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-xl text-xs font-semibold px-4 shadow-sm">Dashboard Admin</a>
            @endauth
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto p-6 md:p-12 w-full space-y-8">
        
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-800 md:text-4xl">Katalog Komoditas UMKM</h1>
            <p class="text-xs text-slate-500 font-medium leading-relaxed">Platform digital publikasi produk usaha mikro, kecil, dan menengah lokal guna memperluas jangkauan pasar ekosistem digital.</p>
        </div>

        <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row gap-3 max-w-4xl mx-auto bg-base-100 p-4 rounded-xl border border-blue-100 shadow-sm">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="input input-bordered border-blue-100 input-sm w-full rounded-lg text-slate-700 text-xs focus:outline-blue-400" />
            </div>
            <div class="w-full sm:w-48">
                <select name="category" class="select select-bordered border-blue-100 select-sm w-full rounded-lg text-slate-700 text-xs focus:outline-blue-400">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-lg text-xs px-6 shadow-sm">
                    Cari
                </button>
                @if(request('search') || request('category'))
                    <a href="{{ route('home') }}" class="btn btn-ghost border border-slate-200 btn-sm rounded-lg text-xs px-4">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if(request('search'))
            <div class="max-w-4xl mx-auto text-xs text-slate-500">
                Menampilkan hasil pencarian untuk kata kunci: <span class="font-bold text-blue-600">"{{ request('search') }}"</span>
            </div>
        @endif

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

                    <div class="space-y-2">
                        <div class="text-base font-black text-blue-600 tracking-tight">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        
                        <button onclick="document.getElementById('modal_detail_{{ $product->id }}').showModal()" class="btn btn-ghost border border-slate-200 hover:bg-slate-50 btn-sm w-full rounded-xl text-xs font-semibold tracking-wide">
                            Detail Produk
                        </button>

                        <a href="https://wa.me/{{ $product->store->whatsapp }}?text=Halo%20{{ urlencode($product->store->nama_toko) }},%20saya%20tertarik%20dengan%20produk%20*{{ urlencode($product->name) }}*%20yang%20tertera%20pada%20E-Katalog." 
                           target="_blank" 
                           class="btn bg-emerald-600 hover:bg-emerald-700 text-white border-none btn-sm w-full rounded-xl text-xs font-semibold tracking-wide shadow-sm">
                           Hubungi Penjual
                        </a>
                    </div>
                </div>

            </div>

            <dialog id="modal_detail_{{ $product->id }}" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box bg-base-100 max-w-2xl border border-blue-100 rounded-2xl p-0 overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/2 h-64 md:h-auto bg-slate-100">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                        </div>
                        <div class="w-full md:w-1/2 p-6 flex flex-col justify-between space-y-6">
                            <div class="space-y-4">
                                <div>
                                    <span class="bg-blue-50 text-blue-700 text-[9px] font-bold px-2 py-1 rounded border border-blue-100 uppercase tracking-tight">
                                        {{ $product->category->nama_kategori }}
                                    </span>
                                    <h3 class="text-lg font-bold text-slate-800 mt-2">{{ $product->name }}</h3>
                                    <div class="text-xl font-black text-blue-600 tracking-tight mt-1">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="h-[1px] bg-slate-100"></div>

                                <div class="space-y-1">
                                    <h4 class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Deskripsi Produk</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed max-h-32 overflow-y-auto pr-1">
                                        {{ $product->description }}
                                    </p>
                                </div>

                                <div class="h-[1px] bg-slate-100"></div>

                                <div class="space-y-1 p-3 bg-blue-50/40 rounded-xl border border-blue-50">
                                    <h4 class="text-[10px] uppercase font-bold tracking-wider text-slate-500">Informasi UMKM</h4>
                                    <p class="text-xs font-bold text-slate-800">{{ $product->store->nama_toko }}</p>
                                    <p class="text-[11px] text-slate-500 leading-normal mt-0.5"><span class="font-medium text-slate-400">Alamat:</span> {{ $product->store->alamat }}</p>
                                </div>
                            </div>

                            <div class="flex gap-2 pt-2">
                                <form method="dialog" class="flex-1 m-0 p-0">
                                    <button class="btn btn-ghost border border-slate-200 w-full btn-sm rounded-xl text-xs font-semibold">Tutup</button>
                                </form>
                                <a href="https://wa.me/{{ $product->store->whatsapp }}?text=Halo%20{{ urlencode($product->store->nama_toko) }},%20saya%20tertarik%20dengan%20produk%20*{{ urlencode($product->name) }}*%20yang%20tertera%20pada%20E-Katalog." 
                                   target="_blank" 
                                   class="btn bg-emerald-600 hover:bg-emerald-700 text-white border-none btn-sm flex-1 rounded-xl text-xs font-semibold tracking-wide shadow-sm text-center flex items-center justify-center">
                                   Beli Produk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop bg-slate-900/40 backdrop-blur-xs">
                    <button>close</button>
                </form>
            </dialog>

            @empty
            <div class="col-span-full py-20 bg-blue-50/20 rounded-2xl border border-dashed border-blue-200 text-center max-w-4xl mx-auto w-full">
                <p class="text-sm font-bold text-slate-700">Produk Tidak Ditemukan</p>
                <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">Kata kunci atau filter kategori yang Anda masukkan tidak cocok dengan data komoditas produk mana pun dalam sistem kami.</p>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-lg text-xs px-6 shadow-sm">Lihat Semua Produk</a>
                </div>
            </div>
            @endforelse
        </div>

    </main>

    <footer class="footer footer-center p-4 bg-base-100 text-slate-400 border-t border-blue-100 text-[10px] font-semibold uppercase tracking-wider mt-12">
        <div>
            <p>© 2026 Proyek Web E-Katalog - Universitas Muhammadiyah Kalimantan Timur</p>
        </div>
    </footer>

</body>
</html>