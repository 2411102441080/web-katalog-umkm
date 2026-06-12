<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mitra UMKM Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-center items-center p-6 antialiased text-slate-700">
        
    <div class="w-full max-w-lg bg-white border border-blue-100 shadow-sm rounded-2xl p-6 md:p-8 space-y-6my-8">
        
        <div class="text-center space-y-1">
            <h2 class="text-xl font-extrabold tracking-tight text-slate-800 uppercase">Pendaftaran Mitra</h2>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Bergabung ke Ekosistem E-Katalog</p>
        </div>

        <div class="h-[1px] bg-blue-50"></div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 m-0 p-0">
            @csrf

            <div class="space-y-3">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest block">1. Informasi Akun Pengguna</span>
                
                <div class="form-control w-full">
                    <label class="label pb-1" for="name">
                        <span class="label-text font-bold text-slate-600 text-xs">Nama Lengkap Pemilik</span>
                    </label>
                    <input id="name" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    @if ($errors->get('name'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="form-control w-full">
                    <label class="label pb-1" for="email">
                        <span class="label-text font-bold text-slate-600 text-xs">Alamat Email Resmi</span>
                    </label>
                    <input id="email" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    @if ($errors->get('email'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="form-control w-full">
                        <label class="label pb-1" for="password">
                            <span class="label-text font-bold text-slate-600 text-xs">Kata Sandi</span>
                        </label>
                        <input id="password" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="password" name="password" required autocomplete="new-password" />
                        @if ($errors->get('password'))
                            <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <div class="form-control w-full">
                        <label class="label pb-1" for="password_confirmation">
                            <span class="label-text font-bold text-slate-600 text-xs">Konfirmasi Sandi</span>
                        </label>
                        <input id="password_confirmation" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                </div>
            </div>

            <div class="h-[1px] bg-slate-100 my-2"></div>

            <div class="space-y-3">
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest block">2. Informasi Badan Usaha / Toko</span>

                <div class="form-control w-full">
                    <label class="label pb-1" for="nama_toko">
                        <span class="label-text font-bold text-slate-600 text-xs">Nama Toko UMKM</span>
                    </label>
                    <input id="nama_toko" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="text" name="nama_toko" value="{{ old('nama_toko') }}" required />
                    @if ($errors->get('nama_toko'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('nama_toko') }}</div>
                    @endif
                </div>

                <div class="form-control w-full">
                    <label class="label pb-1" for="whatsapp">
                        <span class="label-text font-bold text-slate-600 text-xs">Nomor WhatsApp Aktif</span>
                    </label>
                    <input id="whatsapp" placeholder="Contoh: 08123456789" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="text" name="whatsapp" value="{{ old('whatsapp') }}" required />
                    @if ($errors->get('whatsapp'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('whatsapp') }}</div>
                    @endif
                </div>

                <div class="form-control w-full">
                    <label class="label pb-1" for="alamat">
                        <span class="label-text font-bold text-slate-600 text-xs">Alamat Lengkap Toko</span>
                    </label>
                    <textarea id="alamat" rows="2" class="textarea textarea-bordered border-blue-100 w-full rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400 p-2.5 min-h-[70px]" name="alamat" required>{{ old('alamat') }}</textarea>
                    @if ($errors->get('alamat'))
                        <div class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $errors->first('alamat') }}</div>
                    @endif
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm w-full h-9 min-h-9 rounded-xl text-xs font-bold tracking-wide shadow-xs transition-colors uppercase">
                    Ajukan Pendaftaran Mitra
                </button>
            </div>
        </form>

        <div class="text-center pt-2 border-t border-slate-50 flex justify-between items-center text-[11px] font-bold uppercase tracking-wider">
            <a href="/" class="text-slate-400 hover:text-blue-500 transition-colors">
                ← Ke Katalog
            </a>
            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 transition-colors">
                Sudah Punya Akun? Login
            </a>
        </div>

    </div>

</body>
</html>