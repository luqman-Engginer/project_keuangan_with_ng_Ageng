@extends('layouts.app')

@section('title', 'Isi Saldo')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="mb-1 text-xl font-semibold">Isi Saldo</h1>
        <p class="mb-5 text-sm text-slate-500">Saldo yang Anda isi akan tercatat sebagai pemasukan.</p>

        <form method="POST" action="{{ route('topup.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="jumlah" class="mb-1 block text-sm font-medium">Jumlah (Rp)</label>
                <input id="jumlah" type="number" name="jumlah" min="1" step="1" required
                       value="{{ old('jumlah') }}" placeholder="Contoh: 100000"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="tanggal" class="mb-1 block text-sm font-medium">Tanggal</label>
                <input id="tanggal" type="date" name="tanggal" required max="{{ now()->toDateString() }}"
                       value="{{ old('tanggal', now()->toDateString()) }}"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="keterangan" class="mb-1 block text-sm font-medium">Keterangan <span class="font-normal text-slate-400">(opsional)</span></label>
                <input id="keterangan" type="text" name="keterangan" maxlength="255"
                       value="{{ old('keterangan', 'Isi saldo') }}"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    Isi Saldo Sekarang
                </button>
                <a href="{{ route('dashboard') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
