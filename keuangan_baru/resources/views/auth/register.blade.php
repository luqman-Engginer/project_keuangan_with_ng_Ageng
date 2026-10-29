<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun — {{ config('app.name') }}</title>
    <script>try{var t=localStorage.getItem('theme');if(t==='dark')document.documentElement.classList.add('dark')}catch(e){}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center py-10 px-4 font-sans antialiased">

    <div id="toast-stack" class="toast-stack"></div>

    <div class="w-full max-w-[400px]">

        <div class="text-center mb-7">
            <div class="mx-auto w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="mt-4 text-xl font-semibold text-slate-900 dark:text-white">Buat akun baru</h1>
            <p class="text-sm text-slate-500 mt-1">Mulai catat keuangan Anda</p>
        </div>

        <div class="card p-6 sm:p-7">

            @if ($errors->any())
                <div class="alert-error mb-5">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="form-label" for="nama">Nama Lengkap</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus
                           placeholder="Nama lengkap Anda"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label" for="email">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           placeholder="email@contoh.com"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               placeholder="Minimal 8 karakter"
                               class="form-input pr-11">
                        <button type="button" data-toggle-pw="password" aria-label="Tampilkan kata sandi"
                            class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               placeholder="Ulangi kata sandi"
                               class="form-input pr-11">
                        <button type="button" data-toggle-pw="password_confirmation" aria-label="Tampilkan kata sandi"
                            class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full mt-2">
                    Buat Akun
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">Masuk di sini</a>
            </p>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">{{ config('app.name') }} &copy; {{ date('Y') }}</p>
    </div>

</body>
</html>
