@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun Anda')

@section('content')
<div class="max-w-xl mx-auto">

    {{-- Profile Card --}}
    <div class="card mb-5">
        <div class="p-6 flex items-center gap-4 border-b border-slate-100">
            <div class="w-14 h-14 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 font-semibold text-xl shrink-0">
                {{ strtoupper(substr($user->nama, 0, 1)) }}
            </div>
            <div>
                <p class="text-lg font-bold text-slate-800">{{ $user->nama }}</p>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="{{ $user->isAdmin() ? 'badge-admin' : 'badge-user' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="{{ $user->isAktif() ? 'badge-aktif' : 'badge-nonaktif' }}">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                        {{ ucfirst($user->status) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50/60 text-xs text-slate-500 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Bergabung sejak {{ $user->created_at->translatedFormat('d MMMM Y') }}
        </div>
    </div>

    {{-- Edit Form --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="font-bold text-slate-800">Ubah Informasi Akun</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui nama, email, atau kata sandi</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label" for="nama">Nama Lengkap</label>
                <input id="nama" type="text" name="nama" required maxlength="255"
                       value="{{ old('nama', $user->nama) }}"
                       class="form-input"
                       placeholder="Nama lengkap Anda">
            </div>

            <div>
                <label class="form-label" for="email">Alamat Email</label>
                <input id="email" type="email" name="email" required maxlength="255"
                       value="{{ old('email', $user->email) }}"
                       class="form-input"
                       placeholder="email@contoh.com">
            </div>

            <div class="rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
                    <p class="text-xs font-semibold text-slate-600 uppercase tracking-wide">Ganti Kata Sandi</p>
                    <p class="text-xs text-slate-400 mt-0.5">Kosongkan jika tidak ingin mengubah kata sandi</p>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <label class="form-label" for="password">Kata Sandi Baru</label>
                        <input id="password" type="password" name="password"
                               class="form-input"
                               placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="form-input"
                               placeholder="Ulangi kata sandi baru">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
