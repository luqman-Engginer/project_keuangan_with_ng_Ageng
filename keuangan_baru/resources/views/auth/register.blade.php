@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="mx-auto max-w-md">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="mb-1 text-xl font-semibold">Daftar Akun</h1>
        <p class="mb-5 text-sm text-slate-500">Buat akun baru untuk mulai mencatat keuangan.</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="nama" class="mb-1 block text-sm font-medium">Nama Lengkap</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <p class="mt-1 text-xs text-slate-400">Minimal 8 karakter.</p>
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Daftar
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Login di sini</a>
        </p>
    </div>
</div>
@endsection
