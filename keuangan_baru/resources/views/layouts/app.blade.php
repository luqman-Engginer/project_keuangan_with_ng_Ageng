<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <nav class="bg-white border-b border-slate-200 shadow-sm">
        <div class="mx-auto max-w-6xl px-4 py-3 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-6 flex-wrap">
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-blue-700">💰 {{ config('app.name') }}</a>
                @auth
                    <div class="flex items-center gap-4 text-sm flex-wrap">
                        <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-blue-700">Dashboard</a>
                        <a href="{{ route('transactions.index') }}" class="text-slate-600 hover:text-blue-700">Catatan</a>
                        <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}" class="text-slate-600 hover:text-blue-700">+ Pemasukan</a>
                        <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}" class="text-slate-600 hover:text-blue-700">+ Pengeluaran</a>
                        <a href="{{ route('categories.index') }}" class="text-slate-600 hover:text-blue-700">Kategori</a>
                        <a href="{{ route('topup.create') }}" class="text-slate-600 hover:text-blue-700">Isi Saldo</a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}" class="font-medium text-amber-600 hover:text-amber-700">Kelola User</a>
                        @endif
                    </div>
                @endauth
            </div>
            <div class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('profile.edit') }}" class="text-slate-600 hover:text-blue-700">👤 {{ auth()->user()->nama }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-md bg-slate-800 px-3 py-1.5 font-medium text-white hover:bg-slate-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-700">Login</a>
                    <a href="{{ route('register') }}" class="rounded-md bg-blue-600 px-3 py-1.5 font-medium text-white hover:bg-blue-700">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-6">
        @if (session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mx-auto max-w-6xl px-4 pb-6 text-center text-xs text-slate-400">
        Aplikasi Pencatatan Keuangan — Tugas Sekolah
    </footer>
</body>
</html>
