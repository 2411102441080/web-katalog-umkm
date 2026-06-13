<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Panel Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-center items-center p-6 antialiased text-slate-700">
        
    <div class="w-full max-w-md bg-white border border-blue-100 shadow-sm rounded-2xl p-6 md:p-8 space-y-6">
        
        <div class="text-center space-y-1">
            <h2 class="text-xl font-extrabold tracking-tight text-slate-800 uppercase">E-Katalog UMKM</h2>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Gerbang Masuk Admin</p>
        </div>

        <div class="h-[1px] bg-blue-50"></div>

        @if (session('status'))
            <div class="text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-100 p-3 rounded-xl">
                {{ session('status') }}
            </div>
        @endif
        @if (session('success'))
            <div class="p-4 mb-4 text-xs font-medium text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-4 m-0 p-0">
            @csrf

            <div class="form-control w-full">
                <label class="label pb-1" for="email">
                    <span class="label-text font-bold text-slate-600 text-xs">Alamat Email</span>
                </label>
                <input id="email" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                
                @if ($errors->get('email'))
                    <div class="mt-1 text-[11px] text-rose-600 font-semibold">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="form-control w-full">
                <label class="label pb-1" for="password">
                    <span class="label-text font-bold text-slate-600 text-xs">Kata Sandi</span>
                </label>
                <input id="password" class="input input-bordered border-blue-100 input-sm w-full h-9 rounded-xl text-slate-700 text-xs focus:outline-blue-400 focus:border-blue-400" type="password" name="password" required autocomplete="current-password" />
                
                @if ($errors->get('password'))
                    <div class="mt-1 text-[11px] text-rose-600 font-semibold">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" class="rounded border-blue-200 text-blue-600 focus:ring-blue-400 focus:ring-offset-0 w-3.5 h-3.5" name="remember">
                    <span class="ms-2 text-xs font-medium text-slate-500 hover:text-slate-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-blue-500 hover:text-blue-600 transition-colors" href="{{ route('password.request') }}">
                        Lupa Sandi?
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white border-none btn-sm w-full h-9 min-h-9 rounded-xl text-xs font-bold tracking-wide shadow-xs transition-colors uppercase">
                    Masuk Sistem
                </button>
            </div>
        </form>

        <div class="text-center pt-2 border-t border-slate-50">
            <a href="/" class="text-[11px] font-bold text-slate-400 hover:text-blue-500 uppercase tracking-wider transition-colors">
                ← Kembali ke Katalog
            </a>
        </div>

    </div>

</body>
</html>