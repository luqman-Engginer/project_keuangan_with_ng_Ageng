@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-semibold">Kategori</h1>
    <p class="text-sm text-slate-500">Kategori bawaan bisa dipakai semua orang. Kategori buatan Anda hanya terlihat oleh Anda.</p>
</div>

@if ($errors->has('kategori'))
    <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        {{ $errors->first('kategori') }}
    </div>
@endif

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold">Kategori Buatan Anda</h2>
        </div>

        <form method="POST" action="{{ route('categories.store') }}" class="flex flex-wrap items-end gap-3 border-b border-slate-200 px-5 py-4">
            @csrf
            <div class="min-w-40 flex-1">
                <label for="nama" class="mb-1 block text-sm font-medium">Nama Kategori</label>
                <input id="nama" type="text" name="nama" required maxlength="100" value="{{ old('nama') }}"
                       placeholder="Contoh: Kopi Manual"
                       class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label for="tipe" class="mb-1 block text-sm font-medium">Tipe</label>
                <select id="tipe" name="tipe" required class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    <option value="pemasukan" @selected(old('tipe') === 'pemasukan')>Pemasukan</option>
                    <option value="pengeluaran" @selected(old('tipe') === 'pengeluaran')>Pengeluaran</option>
                </select>
            </div>
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Tambah
            </button>
        </form>

        <ul class="divide-y divide-slate-100">
            @forelse ($categories as $category)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <div>
                        <span class="font-medium">{{ $category->nama }}</span>
                        <span class="ml-2 rounded-full px-2 py-0.5 text-xs {{ $category->tipe === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($category->tipe) }}
                        </span>
                    </div>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}"
                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Hapus</button>
                    </form>
                </li>
            @empty
                <li class="px-5 py-8 text-center text-sm text-slate-400">Anda belum membuat kategori sendiri.</li>
            @endforelse
        </ul>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold">Kategori Bawaan</h2>
            <p class="text-xs text-slate-400">Tidak bisa diubah atau dihapus.</p>
        </div>

        <ul class="divide-y divide-slate-100">
            @foreach ($bawaan as $category)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <span class="font-medium">{{ $category->nama }}</span>
                    <span class="rounded-full px-2 py-0.5 text-xs {{ $category->tipe === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($category->tipe) }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
