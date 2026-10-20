<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 text-slate-800">
    <div class="mx-4 w-full max-w-md rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <p class="text-5xl font-bold text-red-500">403</p>
        <h1 class="mt-3 text-xl font-semibold">Akses Ditolak</h1>
        <p class="mt-2 text-sm text-slate-500">
            {{ $exception->getMessage() ?: 'Anda tidak punya akses ke halaman ini.' }}
        </p>
        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
           class="mt-6 inline-block rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            Kembali
        </a>
    </div>
</body>
</html>
