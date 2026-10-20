@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="mb-1 text-xl font-semibold">Profil Saya</h1>
        <p class="mb-5 text-sm text-slate-500">Perbarui nama, email, atau password Anda.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="mb-1 block text-sm font-medium">Nama Lengkap</label>
                <input id="nama" type="text" name="nama" required maxlength="255"
                       value="{{ old('nama', $user->nama) }}"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input id="email" type="email" name="email" required maxlength="255"
                       value="{{ old('email', $user->email) }}"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Password Baru <span class="font-normal text-slate-400">(opsional)</span></label>
                <input id="password" type="password" name="password"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <p class="mt-1 text-xs text-slate-400">Kosongkan jika tidak ingin mengganti password. Minimal 8 karakter.</p>
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="rounded-md bg-slate-50 px-4 py-3 text-sm text-slate-600">
                Bergabung sejak {{ $user->created_at->translatedFormat('d M Y') }} ·
                Role: <span class="font-medium">{{ ucfirst($user->role) }}</span> ·
                Status: <span class="font-medium">{{ ucfirst($user->status) }}</span>
            </div>

            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
