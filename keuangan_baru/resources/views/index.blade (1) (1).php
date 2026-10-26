@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')
@section('page-subtitle', 'Manajemen akun pengguna sistem')

@section('content')

{{-- Stats Row --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @php
        $totalUsers = $users->total();
        $totalAktif = \App\Models\User::where('status', 'aktif')->count();
        $totalNonaktif = \App\Models\User::where('status', 'nonaktif')->count();
        $totalAdmin = \App\Models\User::where('role', 'admin')->count();
    @endphp
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Total Pengguna</p>
        <p class="text-2xl font-bold text-slate-800">{{ \App\Models\User::count() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wide mb-1">Akun Aktif</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalAktif }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-rose-600 uppercase tracking-wide mb-1">Akun Nonaktif</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalNonaktif }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-amber-600 uppercase tracking-wide mb-1">Admin</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalAdmin }}</p>
    </div>
</div>

<div class="card">
    {{-- Search --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-3 p-5 border-b border-slate-100 bg-slate-50/60">
        <div class="flex-1 min-w-56">
            <label class="form-label" for="q">Cari Pengguna</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input id="q" type="text" name="q" value="{{ $q }}"
                       placeholder="Ketik nama atau email..."
                       class="form-input pl-10">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Cari
            </button>
            @if ($q !== '')
                <a href="{{ route('admin.users.index') }}" class="btn-secondary btn-sm">Reset</a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="text-slate-400 text-xs font-mono">{{ $user->id }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $user->nama }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="{{ $user->isAdmin() ? 'badge-admin' : 'badge-user' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="{{ $user->isAktif() ? 'badge-aktif' : 'badge-nonaktif' }}">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="text-right whitespace-nowrap">
                            @if ($user->id !== auth()->id())
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-colors
                                                {{ $user->isAktif()
                                                    ? 'text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100'
                                                    : 'text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100' }}">
                                            @if ($user->isAktif())
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                                Nonaktifkan
                                            @else
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Aktifkan
                                            @endif
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            data-confirm="Yakin ingin menghapus akun {{ $user->nama }}? Seluruh data keuangannya akan ikut terhapus secara permanen."
                                            class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-700 px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic px-2">Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            <p class="font-medium">Tidak ada pengguna ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    @endif
</div>

@endsection
