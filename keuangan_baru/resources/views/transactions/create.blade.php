@extends('layouts.app')

@php($isPemasukan = $tipe === 'pemasukan')
@section('title', $isPemasukan ? 'Tambah Pemasukan' : 'Tambah Pengeluaran')
@section('page-title', $isPemasukan ? 'Tambah Pemasukan' : 'Tambah Pengeluaran')
@section('page-subtitle', 'Isi data catatan keuangan dengan benar')

@section('content')
<div class="max-w-xl mx-auto">

    {{-- Type Selector --}}
    <div class="flex gap-2 mb-5 p-1.5 bg-white rounded-2xl border border-slate-200 shadow-sm">
        <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}"
            class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                {{ $isPemasukan ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
            Pemasukan
        </a>
        <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}"
            class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                {{ ! $isPemasukan ? 'bg-gradient-to-r from-rose-500 to-pink-600 text-white shadow-lg shadow-rose-500/30' : 'text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
            Pengeluaran
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center
                    {{ $isPemasukan ? 'bg-emerald-100' : 'bg-rose-100' }}">
                    @if ($isPemasukan)
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                    @else
                        <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                    @endif
                </div>
                <div>
                    <h2 class="font-bold text-slate-800">Catatan {{ $isPemasukan ? 'Pemasukan' : 'Pengeluaran' }}</h2>
                    <p class="text-xs text-slate-500">Lengkapi data di bawah ini</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('transactions.store') }}" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="tipe" value="{{ $tipe }}">

            @include('transactions._form', ['transaction' => null])

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="{{ $isPemasukan ? 'btn-success' : 'btn-danger' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Simpan Catatan
                </button>
                <a href="{{ route('transactions.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
