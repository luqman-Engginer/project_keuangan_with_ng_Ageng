@extends('layouts.app')

@section('title', 'Isi Saldo')
@section('page-title', 'Isi Saldo')
@section('page-subtitle', 'Top-up saldo yang tercatat sebagai pemasukan')

@section('content')
<div class="max-w-xl mx-auto">

    {{-- Info Banner --}}
    <div class="flex items-start gap-4 p-4 mb-5 rounded-2xl border border-indigo-200 bg-gradient-to-r from-indigo-50 to-purple-50">
        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-indigo-800">Isi Saldo / Top-Up</p>
            <p class="text-xs text-indigo-600 mt-0.5">Saldo yang Anda isi akan otomatis tercatat sebagai pemasukan dengan kategori <strong>Isi Saldo</strong>.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800">Form Isi Saldo</h2>
                    <p class="text-xs text-slate-500">Masukkan jumlah saldo yang ingin ditambahkan</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('topup.store') }}" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="form-label" for="jumlah">Jumlah Top-Up (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-semibold text-sm">Rp</span>
                    <input id="jumlah" type="number" name="jumlah" min="1" step="1" required
                           value="{{ old('jumlah') }}"
                           placeholder="0"
                           class="form-input pl-10">
                </div>
            </div>

            <div>
                <label class="form-label" for="tanggal">Tanggal</label>
                <input id="tanggal" type="date" name="tanggal" required max="{{ now()->toDateString() }}"
                       value="{{ old('tanggal', now()->toDateString()) }}"
                       class="form-input">
            </div>

            <div>
                <label class="form-label" for="keterangan">Keterangan <span class="font-normal text-slate-400">(opsional)</span></label>
                <input id="keterangan" type="text" name="keterangan" maxlength="255"
                       value="{{ old('keterangan', 'Isi saldo') }}"
                       placeholder="Contoh: Top-up via transfer"
                       class="form-input">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Isi Saldo Sekarang
                </button>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
