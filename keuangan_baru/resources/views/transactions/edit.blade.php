@extends('layouts.app')

@php($isPemasukan = $transaction->tipe === 'pemasukan')
@section('title', 'Edit Catatan')
@section('page-title', 'Edit Catatan')
@section('page-subtitle', 'Perbarui data catatan keuangan Anda')

@section('content')
<div class="max-w-xl mx-auto">
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
                    <h2 class="font-bold text-slate-800">Edit Catatan {{ $isPemasukan ? 'Pemasukan' : 'Pengeluaran' }}</h2>
                    <p class="text-xs text-slate-500">Catatan dibuat pada {{ $transaction->created_at->translatedFormat('d M Y') }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" name="tipe" value="{{ $transaction->tipe }}">

            @include('transactions._form', ['transaction' => $transaction])

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('transactions.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
