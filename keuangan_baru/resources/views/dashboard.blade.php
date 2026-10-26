@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan keuangan Anda hari ini')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

    {{-- Total Pemasukan --}}
    <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
        <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
            <svg viewBox="0 0 100 100" fill="white"><circle cx="80" cy="20" r="60"/></svg>
        </div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <span class="text-emerald-200 text-xs font-semibold px-2.5 py-1 bg-white/10 rounded-full">Total</span>
            </div>
            <p class="text-emerald-100 text-sm font-medium mb-1">Total Pemasukan</p>
            <p class="text-white text-2xl font-bold">{{ rupiah($totalPemasukan) }}</p>
        </div>
    </div>

    {{-- Total Pengeluaran --}}
    <div class="stat-card" style="background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);">
        <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
            <svg viewBox="0 0 100 100" fill="white"><circle cx="80" cy="20" r="60"/></svg>
        </div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <span class="text-rose-200 text-xs font-semibold px-2.5 py-1 bg-white/10 rounded-full">Total</span>
            </div>
            <p class="text-rose-100 text-sm font-medium mb-1">Total Pengeluaran</p>
            <p class="text-white text-2xl font-bold">{{ rupiah($totalPengeluaran) }}</p>
        </div>
    </div>

    {{-- Saldo --}}
    <div class="stat-card" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
        <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
            <svg viewBox="0 0 100 100" fill="white"><circle cx="80" cy="20" r="60"/></svg>
        </div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <span class="text-indigo-200 text-xs font-semibold px-2.5 py-1 bg-white/10 rounded-full">Saldo</span>
            </div>
            <p class="text-indigo-100 text-sm font-medium mb-1">Saldo Saat Ini</p>
            <p class="text-white text-2xl font-bold">{{ rupiah($saldo) }}</p>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
    <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}"
        class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-200 group">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
            <svg class="w-5 h-5 text-emerald-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
        </div>
        <span class="text-xs font-semibold text-slate-600 text-center">Tambah Pemasukan</span>
    </a>
    <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}"
        class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-rose-200 transition-all duration-200 group">
        <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center group-hover:bg-rose-500 transition-colors">
            <svg class="w-5 h-5 text-rose-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
        </div>
        <span class="text-xs font-semibold text-slate-600 text-center">Tambah Pengeluaran</span>
    </a>
    <a href="{{ route('topup.create') }}"
        class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-200 group">
        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-500 transition-colors">
            <svg class="w-5 h-5 text-indigo-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
        </div>
        <span class="text-xs font-semibold text-slate-600 text-center">Isi Saldo</span>
    </a>
    <a href="{{ route('categories.index') }}"
        class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200 group">
        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center group-hover:bg-amber-500 transition-colors">
            <svg class="w-5 h-5 text-amber-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
        </div>
        <span class="text-xs font-semibold text-slate-600 text-center">Kategori</span>
    </a>
</div>

{{-- Recent Transactions --}}
<div class="card">
    <div class="card-header">
        <div>
            <h2 class="text-base font-bold text-slate-800">Transaksi Terbaru</h2>
            <p class="text-xs text-slate-500 mt-0.5">10 transaksi terakhir</p>
        </div>
        <a href="{{ route('transactions.index') }}"
            class="text-sm text-indigo-600 font-semibold hover:text-indigo-700 flex items-center gap-1">
            Lihat Semua
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
                        <td class="whitespace-nowrap text-slate-500">
                            {{ $transaction->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td class="font-medium text-slate-800">{{ $transaction->keterangan ?? '—' }}</td>
                        <td>
                            <span class="text-xs px-2 py-1 rounded-lg bg-slate-100 text-slate-600 font-medium">
                                {{ $transaction->category->nama }}
                            </span>
                        </td>
                        <td>
                            @if ($transaction->tipe === 'pemasukan')
                                <span class="badge-pemasukan">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                    Pemasukan
                                </span>
                            @else
                                <span class="badge-pengeluaran">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    Pengeluaran
                                </span>
                            @endif
                        </td>
                        <td class="text-right whitespace-nowrap font-bold {{ $transaction->tipe === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $transaction->tipe === 'pemasukan' ? '+' : '−' }} {{ rupiah($transaction->jumlah) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-16 text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            <p class="font-medium">Belum ada transaksi</p>
                            <p class="text-xs mt-1">Mulai catat pemasukan atau pengeluaran Anda</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
