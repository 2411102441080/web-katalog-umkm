<!DOCTYPE html>
<html lang="id" data-theme="light" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Katalog Resmi UMKM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-700 antialiased relative" 
      style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%231e40af' stroke-width='1' stroke-opacity='0.03'%3E%3Cpath d='M30 0v60M0 30h60M0 0l60 60M60 0L0 60'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;); background-attachment: fixed;">

    <nav class="navbar bg-base-100/90 backdrop-blur-md border-b border-blue-100 px-4 md:px-12 sticky top-0 z-50 shadow-xs">
        <div class="flex-1">
            <a href="/" class="text-lg font-bold tracking-tight text-slate-800 uppercase">E-Katalog UMKM</a>
        </div>
        <div class="flex-none flex items-center gap-2">
            @auth
                <a href="{{ route('admin.products.index') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-xl text-xs font-semibold px-4 shadow-sm h-9 min-h-9 flex items-center">
                    Kembali ke Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 inline-flex items-center">
                    @csrf
                    <button type="submit" class="btn btn-ghost hover:bg-rose-50 hover:text-rose-600 border border-slate-200 hover:border-rose-200 btn-sm rounded-xl text-xs font-semibold px-4 h-9 min-h-9" onclick="event.preventDefault(); this.closest('form').submit();">
                        Keluar
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('register') }}" class="btn btn-ghost hover:bg-blue-50 hover:text-blue-700 border border-slate-200 hover:border-blue-300 btn-sm rounded-xl text-xs font-semibold px-4 h-9 min-h-9 flex items-center">
                    Daftar Mitra UMKM
                </a>
                <a href="{{ route('login') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-xl text-xs font-semibold px-4 shadow-sm h-9 min-h-9 flex items-center">
                    Masuk Akun
                </a>
            @endguest
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto p-6 md:p-12 w-full space-y-12 relative z-10">
        
        <div class="relative py-10 md:py-14 text-center max-w-5xl mx-auto w-full">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-gradient-to-tr from-blue-200/30 to-emerald-200/20 rounded-full blur-3xl pointer-events-none z-0"></div>

            <div class="relative z-10 max-w-4xl mx-auto space-y-6 px-4">
                <div class="inline-flex items-center gap-2 bg-white border border-blue-200 px-4 py-1.5 rounded-full text-[10px] font-bold text-blue-800 uppercase tracking-widest mx-auto shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Modernisasi Ekosistem Digital UMKM Samarinda
                </div>
                
                <h1 class="text-3xl font-black tracking-tight text-slate-900 md:text-5xl leading-tight">
                    Pusat Publikasi & Komoditas Resmi <br />
                    <span class="bg-gradient-to-r from-blue-700 to-emerald-700 bg-clip-text text-transparent">Katalog Produk Unggulan UMKM</span>
                </h1>
                
                <p class="text-xs md:text-sm text-slate-600 font-medium leading-relaxed max-w-3xl mx-auto">
                    Selamat datang di platform etalase digital resmi kedeputian UMKM. Kami mengintegrasikan seluruh data komoditas sektor industri kreatif, kerajinan tangan, kuliner khas daerah, hingga produk rumahan lokal secara transparan dan akurat. Temukan kemudahan akses informasi spesifikasi barang, transparansi harga budget, hingga komunikasi negosiasi interaktif terintegrasi langsung bersama pemilik usaha mikro.
                </p>
                
                <div class="pt-2 flex flex-col items-center gap-3">
                    <a href="#katalog-section" class="btn bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white border-none btn-md rounded-xl text-xs font-bold px-10 shadow-md transition-all hover:translate-y-[-2px] tracking-wide uppercase">
                        Mulai Jelajahi Produk
                    </a>
                    
                    <div class="flex items-center gap-1.5 text-slate-500 font-medium pt-1">
                        <span class="text-[9px] uppercase font-bold tracking-widest">Gulir ke bawah untuk menyaring budget & kategori produk</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 animate-bounce text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 pt-8 max-w-2xl mx-auto text-center">
                    <div class="bg-white border border-blue-100 p-3 rounded-2xl shadow-xs">
                        <div class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">{{ $products->count() }}</div>
                        <div class="text-[9px] uppercase tracking-wider text-slate-400 font-bold mt-0.5">Total Komoditas</div>
                    </div>
                    <div class="bg-white border border-blue-100 p-3 rounded-2xl shadow-xs">
                        <div class="text-xl md:text-2xl font-black text-blue-700 tracking-tight">{{ $categories->count() }}</div>
                        <div class="text-[9px] uppercase tracking-wider text-slate-400 font-bold mt-0.5">Kategori Pilihan</div>
                    </div>
                    <div class="bg-white border border-blue-100 p-3 rounded-2xl shadow-xs">
                        <div class="text-xl md:text-2xl font-black text-emerald-700 tracking-tight">{{ $storesCount }}</div>
                        <div class="text-[9px] uppercase tracking-wider text-slate-400 font-bold mt-0.5">Mitra Binaan</div>
                    </div>
                </div>
            </div>
        </div>

        <form id="katalog-section" action="{{ route('home') }}" method="GET" class="space-y-5 max-w-4xl mx-auto bg-white p-5 rounded-2xl border border-blue-100 shadow-sm scroll-mt-20">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <label class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block mb-1.5">Kata Kunci</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk atau nama UMKM..." class="input input-bordered border-blue-100 input-sm w-full rounded-xl text-slate-700 text-xs focus:outline-blue-400 h-9" />
                </div>
                
                <div class="w-full md:w-44">
                    <label class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block mb-1.5">Harga Min (Rp)</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" min="0" placeholder="Contoh: 10000" class="input input-bordered input-sm w-full rounded-xl text-slate-700 text-xs focus:outline-blue-400 h-9 @error('min_price') border-rose-500 @else border-blue-100 @enderror" />
                    @error('min_price')
                        <span class="text-[10px] text-rose-600 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full md:w-44">
                    <label class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block mb-1.5">Harga Maks (Rp)</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" min="0" placeholder="Contoh: 50000" class="input input-bordered input-sm w-full rounded-xl text-slate-700 text-xs focus:outline-blue-400 h-9 @error('max_price') border-rose-500 @else border-blue-100 @enderror" />
                    @error('max_price')
                        <span class="text-[10px] text-rose-600 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div class="self-end w-full md:w-auto">
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-xl text-xs px-6 shadow-sm h-9 w-full">
                        Filter
                    </button>
                </div>
            </div>

            <div class="space-y-2 border-t border-slate-50 pt-3">
                <label class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Pilih Kategori Produk</label>
                <div class="flex flex-wrap gap-2">
                    <input type="hidden" name="category" id="active_category" value="{{ request('category') }}">
                    <button type="button" onclick="filterCategory('')" class="btn btn-sm rounded-xl text-xs font-semibold tracking-wide border transition-all px-4 h-8 min-h-8 {{ request('category') == '' ? 'bg-blue-600 text-white border-blue-600 shadow-xs' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100 hover:border-slate-300' }}">
                        Semua Kategori
                    </button>
                    @foreach($categories as $category)
                        <button type="button" onclick="filterCategory('{{ $category->id }}')" class="btn btn-sm rounded-xl text-xs font-semibold tracking-wide border transition-all px-4 h-8 min-h-8 {{ request('category') == $category->id ? 'bg-blue-600 text-white border-blue-600 shadow-xs' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100 hover:border-slate-300' }}">
                            {{ $category->nama_kategori }}
                        </button>
                    @endforeach
                </div>
            </div>
        </form>

        <script>
            function filterCategory(id) {
                document.getElementById('active_category').value = id;
                document.getElementById('active_category').closest('form').submit();
            }
        </script>

        @if(request('search') || request('min_price') || request('max_price'))
            <div class="max-w-4xl mx-auto text-xs text-slate-600 flex flex-wrap gap-2 items-center bg-white/80 border border-blue-100 px-4 py-2 rounded-xl shadow-xs">
                <span class="font-semibold text-slate-500">Filter Aktif:</span>
                @if(request('search'))
                    <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md border border-blue-100 font-medium">Kata Kunci: "{{ request('search') }}"</span>
                @endif
                @if(request('min_price') && ! $errors->has('min_price'))
                    <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md border border-slate-200 font-medium">Min: Rp{{ number_format(request('min_price'), 0, ',', '.') }}</span>
                @endif
                @if(request('max_price') && ! $errors->has('max_price'))
                    <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md border border-slate-200 font-medium">Maks: Rp{{ number_format(request('max_price'), 0, ',', '.') }}</span>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
            <div class="card bg-white border border-blue-100 shadow-sm hover:shadow-md transition-all rounded-2xl overflow-hidden flex flex-col justify-between">
                <figure class="h-48 bg-slate-100 relative">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                    <span class="badge bg-blue-600 text-white border-none font-bold text-[9px] uppercase tracking-wider px-2.5 py-2 absolute top-3 right-3 shadow-sm">
                        {{ $product->category->nama_kategori }}
                    </span>
                </figure>

                <div class="p-4 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-1">
                        <span class="text-[9px] uppercase font-bold tracking-wider text-blue-600 font-mono block">
                            {{ $product->store->nama_toko }}
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
            <div class="col-span-full py-20 bg-white/90 rounded-2xl border border-dashed border-blue-200 text-center max-w-4xl mx-auto w-full shadow-xs">
                <p class="text-sm font-bold text-slate-700">Produk atau UMKM Tidak Ditemukan</p>
                <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">Kata kunci, nama UMKM, atau rentang budget harga yang dimasukkan tidak cocok dengan produk mana pun.</p>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm rounded-lg text-xs px-6 shadow-sm">Lihat Semua Produk</a>
                </div>
            </div>
            @endforelse
        </div>

    </main>

    <footer class="bg-white border-t border-blue-100 mt-12 z-10 relative">
        <div class="max-w-7xl mx-auto px-6 py-8 md:py-10 grid grid-cols-1 md:grid-cols-2 gap-6 items-center text-xs">
            
            <div class="text-center md:text-left space-y-1">
                <p class="font-bold text-slate-800 uppercase tracking-wide">Proyek Web E-Katalog v1.0</p>
                <p class="text-slate-500 font-medium">© 2026 Teknik Informatika - Universitas Muhammadiyah Kalimantan Timur</p>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center md:justify-end gap-4 sm:gap-6 text-center sm:text-left text-slate-600 font-semibold uppercase tracking-wider">
                <a href="https://wa.me/6281347912323?text=Halo%20Helpdesk%20E-Katalog%20UMKT" target="_blank" class="flex items-center justify-center sm:justify-start gap-2 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+62 813-4791-2323</span>
                </a>
                
                <a href="mailto:helpdesk@umkt.ac.id" class="flex items-center justify-center sm:justify-start gap-2 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>helpdesk@umkt.ac.id</span>
                </a>
            </div>
            
        </div>
    </footer>

</body>
</html>