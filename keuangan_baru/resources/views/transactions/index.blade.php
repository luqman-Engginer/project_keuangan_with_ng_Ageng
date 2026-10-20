@extends('layouts.app')

@section('title', 'Riwayat Catatan')

@section('content')
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Riwayat Catatan</h1>
        <p class="text-sm text-slate-500">Daftar seluruh pemasukan dan pengeluaran Anda.</p>
    </div>
    <div class="flex gap-2 text-sm">
        <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}" class="rounded-md bg-green-600 px-3 py-2 font-medium text-white hover:bg-green-700">+ Pemasukan</a>
        <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}" class="rounded-md bg-red-600 px-3 py-2 font-medium text-white hover:bg-red-700">+ Pengeluaran</a>
    </div>
</div>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm">
    <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-wrap items-end gap-3 border-b border-slate-200 px-5 py-4">
        <div>
            <label for="tipe" class="mb-1 block text-sm font-medium">Jenis</label>
            <select id="tipe" name="tipe" class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua</option>
                <option value="pemasukan" @selected($filterTipe === 'pemasukan')>Pemasukan</option>
                <option value="pengeluaran" @selected($filterTipe === 'pengeluaran')>Pengeluaran</option>
            </select>
        </div>
        <div>
            <label for="kategori" class="mb-1 block text-sm font-medium">Kategori</label>
            <select id="kategori" name="kategori" class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($filterKategori === $category->id)>
                        {{ $category->nama }} ({{ $category->tipe }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded-md bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Filter</button>
        @if ($filterTipe !== '' || $filterKategori > 0)
            <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:underline">Reset</a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-5 py-3 font-medium">Tanggal</th>
                    <th class="px-5 py-3 font-medium">Keterangan</th>
                    <th class="px-5 py-3 font-medium">Kategori</th>
                    <th class="px-5 py-3 font-medium">Jenis</th>
                    <th class="px-5 py-3 text-right font-medium">Jumlah</th>
                    <th class="px-5 py-3 text-right font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="whitespace-nowrap px-5 py-3">{{ $transaction->tanggal->translatedFormat('d M Y') }}</td>
                        <td class="px-5 py-3">{{ $transaction->keterangan ?? '—' }}</td>
                        <td class="px-5 py-3">
                            {{ $transaction->category->nama }}
                            @if ($transaction->category->isBawaan())
                                <span class="text-xs text-slate-400">(bawaan)</span>
                            @endif
                        </td>
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
                        <td class="whitespace-nowrap px-5 py-3 text-right">
                            <a href="{{ route('transactions.edit', $transaction) }}" class="text-sm font-medium text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="ml-3 inline"
                                  onsubmit="return confirm('Yakin ingin menghapus catatan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-400">Tidak ada catatan yang cocok dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
