@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan keuangan Anda')

@section('content')

@php
    $totalArus = max((float) $totalPemasukan + (float) $totalPengeluaran, 1);
    $persenMasuk = round(((float) $totalPemasukan / $totalArus) * 100);
    $persenKeluar = 100 - $persenMasuk;
@endphp

{{-- Ringkasan --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <div class="card p-5">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-sm text-slate-500">Total Pemasukan</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight tabular-nums text-slate-900 dark:text-white truncate">
                    {{ rupiah($totalPemasukan) }}
                </p>
            </div>
            <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center shrink-0">
                <svg class="w-[18px] h-[18px] text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-slate-400">Seluruh pemasukan tercatat</p>
    </div>

    <div class="card p-5">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-sm text-slate-500">Total Pengeluaran</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight tabular-nums text-slate-900 dark:text-white truncate">
                    {{ rupiah($totalPengeluaran) }}
                </p>
            </div>
            <div class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center shrink-0">
                <svg class="w-[18px] h-[18px] text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-slate-400">Seluruh pengeluaran tercatat</p>
    </div>

    <div class="card p-5" style="background: var(--primary-soft); border-color: rgba(37, 99, 235, .18);">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-sm" style="color: var(--primary-text)">Saldo Saat Ini</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight tabular-nums truncate" style="color: var(--primary-text)">
                    {{ rupiah($saldo) }}
                </p>
            </div>
            <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-[18px] h-[18px] text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs" style="color: var(--primary-text); opacity: .8">Pemasukan dikurangi pengeluaran</p>
    </div>
</div>

{{-- Arus Kas --}}
<div class="card p-5 mb-6">
    <div class="flex items-start justify-between gap-4 mb-5">
        <div>
            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Perbandingan Arus Kas</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pemasukan dibanding pengeluaran dari seluruh catatan</p>
        </div>
        <span class="text-xs font-medium text-slate-500 tabular-nums">{{ $persenMasuk }}% / {{ $persenKeluar }}%</span>
    </div>

    <div class="space-y-4">
        <div>
            <div class="flex items-center justify-between text-xs mb-1.5">
                <span class="text-slate-600 dark:text-slate-300">Pemasukan</span>
                <span class="font-medium text-emerald-600 tabular-nums">{{ $persenMasuk }}%</span>
            </div>
            <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                <div class="h-full rounded-full bg-emerald-500" style="width: {{ $persenMasuk }}%"></div>
            </div>
        </div>
        <div>
            <div class="flex items-center justify-between text-xs mb-1.5">
                <span class="text-slate-600 dark:text-slate-300">Pengeluaran</span>
                <span class="font-medium text-rose-600 tabular-nums">{{ $persenKeluar }}%</span>
            </div>
            <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                <div class="h-full rounded-full bg-rose-500" style="width: {{ $persenKeluar }}%"></div>
            </div>
        </div>
    </div>
</div>

{{-- Aksi Cepat --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}"
        class="card p-4 flex items-center gap-3 hover:border-slate-300 dark:hover:border-slate-700 transition-colors group">
        <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center shrink-0">
            <svg class="w-[18px] h-[18px] text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
        </div>
        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Tambah Pemasukan</span>
    </a>
    <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}"
        class="card p-4 flex items-center gap-3 hover:border-slate-300 dark:hover:border-slate-700 transition-colors group">
        <div class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center shrink-0">
            <svg class="w-[18px] h-[18px] text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
        </div>
        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Tambah Pengeluaran</span>
    </a>
    <a href="{{ route('topup.create') }}"
        class="card p-4 flex items-center gap-3 hover:border-slate-300 dark:hover:border-slate-700 transition-colors group">
        <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center shrink-0">
            <svg class="w-[18px] h-[18px] text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
        </div>
        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Isi Saldo</span>
    </a>
    <a href="{{ route('categories.index') }}"
        class="card p-4 flex items-center gap-3 hover:border-slate-300 dark:hover:border-slate-700 transition-colors group">
        <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center shrink-0">
            <svg class="w-[18px] h-[18px] text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
        </div>
        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Kategori</span>
    </a>
</div>

{{-- Transaksi Terbaru --}}
<div class="card">
    <div class="card-header">
        <div>
            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Transaksi Terbaru</h2>
            <p class="text-xs text-slate-500 mt-0.5">10 transaksi terakhir</p>
        </div>
        <a href="{{ route('transactions.index') }}"
            class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 flex items-center gap-1">
            Lihat semua
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="whitespace-nowrap text-slate-500 text-xs">
                            {{ $transaction->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td class="font-medium text-slate-800 dark:text-slate-200 max-w-xs truncate">{{ $transaction->keterangan ?? '—' }}</td>
                        <td>
                            <span class="text-xs px-2 py-1 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-medium">
                                {{ $transaction->category->nama }}
                            </span>
                        </td>
                        <td>
                            @if ($transaction->tipe === 'pemasukan')
                                <span class="badge-pemasukan">Pemasukan</span>
                            @else
                                <span class="badge-pengeluaran">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="text-right whitespace-nowrap font-semibold tabular-nums {{ $transaction->tipe === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $transaction->tipe === 'pemasukan' ? '+' : '−' }} {{ rupiah($transaction->jumlah) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-14 text-slate-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            <p class="text-sm font-medium text-slate-500">Belum ada transaksi</p>
                            <p class="text-xs mt-1">Mulai catat pemasukan atau pengeluaran Anda</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
