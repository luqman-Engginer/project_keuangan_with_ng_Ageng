<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center font-sans antialiased">
    <div class="text-center px-4 max-w-md mx-auto">
        <div class="w-14 h-14 rounded-xl bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center mx-auto mb-5">
            <svg class="w-7 h-7 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>
        <p class="text-sm font-semibold text-rose-600 tracking-wide">Error 403</p>
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white mt-1 mb-2">Akses Ditolak</h1>
        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
            {{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}
        </p>
        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke {{ auth()->check() ? 'Dashboard' : 'Login' }}
        </a>
    </div>
</body>
</html>
