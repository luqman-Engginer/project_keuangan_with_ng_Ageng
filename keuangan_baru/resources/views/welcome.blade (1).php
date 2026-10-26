<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet">
    <script>try{var t=localStorage.getItem('theme');if(t==='dark'||(!t&&matchMedia('(prefers-color-scheme: dark)').matches))document.documentElement.classList.add('dark')}catch(e){}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased">

    <div class="bg-aurora"></div>
    <div id="toast-stack" class="toast-stack"></div>

    {{-- Sidebar Overlay (mobile) --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 z-50 flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out"
        style="background: linear-gradient(170deg, #0f0c29 0%, #1e1b4b 45%, #312e81 100%); box-shadow: 20px 0 60px -30px rgba(79,70,229,.6);">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-400 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/40 animate-float-slow">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-white font-bold text-sm leading-none">{{ config('app.name') }}</p>
                <p class="text-indigo-300 text-xs mt-0.5">Manajemen Keuangan</p>
            </div>
        </div>

        {{-- Navigation --}}
        @auth
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @if (auth()->user()->isAdmin())
                {{-- Admin Menu --}}
                <p class="px-4 py-2 text-xs font-semibold text-indigo-400 uppercase tracking-widest">Admin</p>
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Kelola Pengguna
                </a>
            @else
                {{-- User Menu --}}
                <p class="px-4 py-2 text-xs font-semibold text-indigo-400 uppercase tracking-widest">Menu Utama</p>
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('transactions.index') }}"
                    class="sidebar-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Riwayat Catatan
                </a>

                <p class="px-4 pt-3 pb-1 text-xs font-semibold text-indigo-400 uppercase tracking-widest">Tambah Catatan</p>
                <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}"
                    class="sidebar-link {{ request()->routeIs('transactions.create') && request('tipe') === 'pemasukan' ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Tambah Pemasukan
                </a>
                <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}"
                    class="sidebar-link {{ request()->routeIs('transactions.create') && request('tipe') === 'pengeluaran' ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
                    Tambah Pengeluaran
                </a>
                <a href="{{ route('topup.create') }}"
                    class="sidebar-link {{ request()->routeIs('topup.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Isi Saldo
                </a>

                <p class="px-4 pt-3 pb-1 text-xs font-semibold text-indigo-400 uppercase tracking-widest">Lainnya</p>
                <a href="{{ route('categories.index') }}"
                    class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    Kategori
                </a>
            @endif
        </nav>

        {{-- User Profile Bottom --}}
        <div class="p-3 border-t border-white/10">
            <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-white/5 mb-2">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-white text-sm font-semibold truncate">{{ auth()->user()->nama }}</p>
                    <p class="text-indigo-300 text-xs truncate">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}"
                class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Profil Saya
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left mt-1 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Keluar
                </button>
            </form>
        </div>
        @endauth
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="lg:ml-64 min-h-screen flex flex-col">

        {{-- Top Bar --}}
        <header class="sticky top-0 z-30 backdrop-blur-xl px-4 lg:px-8 py-3.5 flex items-center justify-between" style="background: var(--surface); border-bottom: 1px solid var(--border);">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <div>
                    <h1 class="text-lg font-extrabold leading-none text-gradient">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs mt-1" style="color: var(--muted)">@yield('page-subtitle', config('app.name'))</p>
                </div>
            </div>
            @auth
            <div class="flex items-center gap-3">
                <button type="button" data-theme-toggle aria-label="Ganti tema"
                    class="relative w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-12 active:scale-90"
                    style="background: var(--surface-solid); border: 1px solid var(--border);">
                    <svg class="w-5 h-5 text-amber-500 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="w-5 h-5 text-indigo-300 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <div class="hidden sm:flex items-center gap-2 text-sm" style="color: var(--muted)">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    </div>
                    <span class="font-medium text-sm">{{ auth()->user()->nama }}</span>
                </div>
            </div>
            @endauth
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-4 lg:p-8">

            {{-- Alert Messages --}}
            @if (session('success'))
                <div hidden data-flash="success" data-title="Berhasil" data-body="{{ session('success') }}"></div>
            @endif

            @if ($errors->any())
                <div class="alert-error mb-5">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        <p class="font-semibold text-rose-700 mb-1">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div data-reveal style="--d:0ms">
                @yield('content')
            </div>
        </main>

        <footer class="text-center text-xs py-5 px-8" style="color: var(--muted); border-top: 1px solid var(--border);">
            {{ config('app.name') }} &copy; {{ date('Y') }} &mdash; Aplikasi Pencatatan Keuangan
        </footer>
    </div>

</body>
</html>
