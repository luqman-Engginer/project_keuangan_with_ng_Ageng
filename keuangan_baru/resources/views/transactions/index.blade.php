@extends('layouts.app')

@section('title', 'Riwayat Catatan')
@section('page-title', 'Riwayat Catatan')
@section('page-subtitle', 'Daftar seluruh pemasukan dan pengeluaran Anda')

@section('content')

{{-- Header Actions --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}" class="btn-success btn-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Pemasukan
        </a>
        <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}" class="btn-danger btn-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
            Pengeluaran
        </a>
    </div>
</div>

{{-- Filter Card --}}
<div class="card mb-5">
    <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-wrap items-end gap-3 p-5">
        <div class="flex-1 min-w-36">
            <label class="form-label">Jenis Transaksi</label>
            <div class="relative">
                <select name="tipe" class="form-select pr-8">
                    <option value="">Semua Jenis</option>
                    <option value="pemasukan" @selected($filterTipe === 'pemasukan')>Pemasukan</option>
                    <option value="pengeluaran" @selected($filterTipe === 'pengeluaran')>Pengeluaran</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
        </div>
        <div class="flex-1 min-w-36">
            <label class="form-label">Kategori</label>
            <div class="relative">
                <select name="kategori" class="form-select pr-8">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($filterKategori === $category->id)>
                            {{ $category->nama }} ({{ ucfirst($category->tipe) }})
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Filter
            </button>
            @if ($filterTipe !== '' || $filterKategori > 0)
                <a href="{{ route('transactions.index') }}" class="btn-secondary btn-sm">Reset</a>
            @endif
        </div>
    </form>
</div>

{{-- Data Table --}}
<div class="card">
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="whitespace-nowrap text-slate-500 text-xs">
                            {{ $transaction->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td class="font-medium text-slate-800 max-w-xs truncate">
                            {{ $transaction->keterangan ?? '—' }}
                        </td>
                        <td>
                            <span class="text-xs px-2 py-1 rounded-lg font-medium
                                {{ $transaction->tipe === 'pemasukan' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                {{ $transaction->category->nama }}
                                @if ($transaction->category->isBawaan())
                                    <span class="text-slate-400">(bawaan)</span>
                                @endif
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
                        <td class="text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('transactions.edit', $transaction) }}"
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700 px-2.5 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('transactions.destroy', $transaction) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        data-confirm="Yakin ingin menghapus catatan ini? Tindakan ini tidak dapat dibatalkan."
                                        class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-700 px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 transition-colors">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            <p class="font-medium">Tidak ada catatan ditemukan</p>
                            <p class="text-xs mt-1">Coba ubah filter atau tambahkan catatan baru</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($transactions->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
    @endif
</div>

@endsection
