<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet">
    <script>try{var t=localStorage.getItem('theme');if(t==='dark')document.documentElement.classList.add('dark')}catch(e){}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center py-8 relative overflow-hidden font-sans antialiased"
      style="background: linear-gradient(135deg, #0b0828 0%, #1e1b4b 45%, #3b0764 100%);">

    {{-- Latar bergerak --}}
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="orb animate-float h-96 w-96 -top-24 -left-24 bg-indigo-500"></div>
        <div class="orb animate-float-slow h-[28rem] w-[28rem] -bottom-32 -right-24 bg-fuchsia-600"></div>
        <div class="orb animate-float h-64 w-64 top-1/3 right-1/4 bg-cyan-500 opacity-30"></div>
        <div class="absolute inset-0 bg-grid"></div>
    </div>

    <div id="toast-stack" class="toast-stack"></div>

    <div class="relative w-full max-w-sm mx-4">

        {{-- Logo --}}
        <div class="text-center mb-8 animate-fade-up">
            <div class="relative mx-auto mb-5 h-16 w-16">
                <span class="absolute inset-0 rounded-2xl bg-gradient-to-br from-indigo-400 to-fuchsia-500 blur-xl opacity-70 animate-pulse"></span>
                <div class="relative h-16 w-16 rounded-2xl bg-gradient-to-br from-indigo-400 via-purple-500 to-pink-500 flex items-center justify-center shadow-2xl shadow-purple-500/50 animate-float-slow">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">{{ config('app.name') }}</h1>
            <p class="text-indigo-200/80 text-sm mt-1.5">Masuk ke akun Anda</p>
        </div>

        {{-- Card --}}
        <div class="rounded-[2rem] p-8 backdrop-blur-2xl animate-fade-up"
             style="animation-delay:.12s; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); box-shadow: 0 40px 80px -30px rgba(0,0,0,.6), inset 0 1px 0 rgba(255,255,255,.2);">

            @if ($errors->any())
                <div class="alert-error mb-5 !bg-rose-500/15 !text-rose-100 !border-rose-400/40">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div class="animate-fade-up" style="animation-delay:310ms">
                    <label class="block text-sm font-semibold text-indigo-100 mb-1.5" for="email">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="email@contoh.com"
                           class="auth-input">
                </div>

                <div class="animate-fade-up" style="animation-delay:400ms">
                    <label class="block text-sm font-semibold text-indigo-100 mb-1.5" for="password">Kata Sandi</label>
                    <div class="relative">
                    <input id="password" type="password" name="password" required
                           placeholder="Masukkan kata sandi"
                           class="auth-input pr-12">
                    <button type="button" data-toggle-pw="password" aria-label="Tampilkan kata sandi"
                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 rounded-lg text-indigo-200/70 hover:text-white hover:bg-white/10 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                </div>

                <button type="submit" class="btn-primary w-full !py-3.5 !text-base mt-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-indigo-200/80 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-white font-bold underline decoration-fuchsia-400 decoration-2 underline-offset-4 hover:text-fuchsia-200 transition">Daftar sekarang</a>
            </p>
        </div>

        <p class="text-center text-xs text-indigo-200/50 mt-6">{{ config('app.name') }} &copy; {{ date('Y') }}</p>
    </div>

</body>
</html>
