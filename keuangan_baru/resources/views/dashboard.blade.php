@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Dashboard</h1>
        <p class="text-sm text-slate-500">Ringkasan keuangan Anda.</p>
    </div>
    <div class="flex gap-2 text-sm">
        <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}" class="rounded-md bg-green-600 px-3 py-2 font-medium text-white hover:bg-green-700">+ Pemasukan</a>
        <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}" class="rounded-md bg-red-600 px-3 py-2 font-medium text-white hover:bg-red-700">+ Pengeluaran</a>
    </div>
</div>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div class="rounded-xl border border-green-200 bg-green-50 p-5">
        <p class="text-sm font-medium text-green-700">Total Pemasukan</p>
        <p class="mt-1 text-2xl font-semibold text-green-800">{{ rupiah($totalPemasukan) }}</p>
    </div>
    <div class="rounded-xl border border-red-200 bg-red-50 p-5">
        <p class="text-sm font-medium text-red-700">Total Pengeluaran</p>
        <p class="mt-1 text-2xl font-semibold text-red-800">{{ rupiah($totalPengeluaran) }}</p>
    </div>
    <div class="rounded-xl border border-blue-200 bg-blue-50 p-5">
        <p class="text-sm font-medium text-blue-700">Saldo Saat Ini</p>
        <p class="mt-1 text-2xl font-semibold text-blue-800">{{ rupiah($saldo) }}</p>
    </div>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
        <h2 class="font-semibold">Transaksi Terbaru</h2>
        <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua →</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-5 py-3 font-medium">Tanggal</th>
                    <th class="px-5 py-3 font-medium">Keterangan</th>
                    <th class="px-5 py-3 font-medium">Kategori</th>
                    <th class="px-5 py-3 font-medium">Jenis</th>
                    <th class="px-5 py-3 text-right font-medium">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="whitespace-nowrap px-5 py-3">{{ $transaction->tanggal->translatedFormat('d M Y') }}</td>
                        <td class="px-5 py-3">{{ $transaction->keterangan ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $transaction->category->nama }}</td>
                        <td class="px-5 py-3">
                            @if ($transaction->tipe === 'pemasukan')
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Pemasukan</span>
                            @else
                                <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-5 py-3 text-right font-medium {{ $transaction->tipe === 'pemasukan' ? 'text-green-700' : 'text-red-700' }}">
                            {{ $transaction->tipe === 'pemasukan' ? '+' : '−' }} {{ rupiah($transaction->jumlah) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-400">Belum ada transaksi. Mulai catat pemasukan atau pengeluaran Anda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
