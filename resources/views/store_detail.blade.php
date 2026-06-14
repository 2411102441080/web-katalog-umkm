<!DOCTYPE html>
<html lang="id" data-theme="light" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk {{ $store->nama_toko }} - E-Katalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-700 antialiased relative" 
      style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%231e40af' stroke-width='1' stroke-opacity='0.03'%3E%3Cpath d='M30 0v60M0 30h60M0 0l60 60M60 0L0 60'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;); background-attachment: fixed;">

    <nav class="navbar bg-base-100/90 backdrop-blur-md border-b border-blue-100 px-4 md:px-12 sticky top-0 z-50 shadow-xs">
        <div class="flex-1">
            <a href="/" class="text-lg font-bold tracking-tight text-slate-800 uppercase">E-Katalog UMKM</a>
        </div>
        <div class="flex-none">
            <a href="/" class="btn btn-ghost border border-slate-200 hover:bg-slate-50 btn-sm rounded-xl text-xs font-semibold px-4 h-9 min-h-9 flex items-center">
                ← Kembali ke Beranda
            </a>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto p-6 md:p-12 w-full space-y-12 relative z-10">
        
        <div class="relative py-10 text-center max-w-4xl mx-auto w-full bg-white border border-blue-100 rounded-3xl shadow-sm p-6 md:p-8">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[200px] bg-gradient-to-tr from-blue-100/30 to-emerald-100/20 rounded-full blur-3xl pointer-events-none z-0"></div>

            <div class="relative z-10 space-y-4">
                <div class="inline-flex items-center gap-1.5 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full text-[10px] font-bold text-blue-700 uppercase tracking-wider">
                    Profil Mitra Binaan
                </div>
                
                <h1 class="text-2xl font-black tracking-tight text-slate-900 md:text-4xl">
                    {{ $store->nama_toko }}
                </h1>
                
                <div class="max-w-xl mx-auto text-xs md:text-sm text-slate-600 font-medium space-y-2">
                    <p><span class="text-slate-400 uppercase font-bold text-[10px] block">Alamat Toko:</span> {{ $store->alamat }}</p>
                </div>

                <div class="pt-2">
                    <a href="https://wa.me/{{ $store->whatsapp }}?text=Halo%20{{ urlencode($store->nama_toko) }},%20saya%20melihat%20profil%20toko%20Anda%20di%20E-Katalog." 
                       target="_blank" 
                       class="btn bg-emerald-600 hover:bg-emerald-700 text-white border-none btn-sm rounded-xl text-xs font-bold px-6 shadow-sm inline-flex items-center gap-2">
                        Hubungi Pemilik UMKM
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto text-center space-y-1">
            <h2 class="text-xl font-extrabold text-slate-900">Daftar Produk yang Tersedia</h2>
            <p class="text-xs text-slate-400 font-medium">Menampilkan seluruh komoditas unggulan resmi dari {{ $store->nama_toko }}</p>
        </div>

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
                        <span class="text-[9px] uppercase font-bold tracking-wider text-slate-400 font-mono block">
                            {{ $store->nama_toko }}
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
                    @auth
                        <a href="https://wa.me/{{ $product->store->whatsapp }}?text=Halo%20{{ urlencode($product->store->nama_toko) }},%20saya%20tertarik%20dengan%20produk%20*{{ urlencode($product->name) }}*%20yang%20tertera%20pada%20E-Katalog." 
                        target="_blank" 
                        class="btn bg-emerald-600 hover:bg-emerald-700 text-white border-none btn-sm flex-1 rounded-xl text-xs font-semibold tracking-wide shadow-sm text-center flex items-center justify-center">
                            Beli Produk
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" 
                        class="btn bg-emerald-600 hover:bg-emerald-700 text-white border-none btn-sm flex-1 rounded-xl text-xs font-semibold tracking-wide shadow-sm text-center flex items-center justify-center"
                        onclick="alert('Silakan login terlebih dahulu untuk membeli produk!');">
                            Beli Produk
                        </a>
                    @endguest
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
                <p class="text-sm font-bold text-slate-700">Belum Ada Produk</p>
                <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">UMKM ini belum mempublikasikan komoditas produknya ke dalam katalog.</p>
            </div>
            @endforelse
        </div>

    </main>

    @include('include.footer')

</body>
</html>