@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'Atur kategori keuangan Anda')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Custom Categories --}}
    <div class="card flex flex-col">
        <div class="card-header">
            <div>
                <h2 class="font-bold text-slate-800">Kategori Kustom</h2>
                <p class="text-xs text-slate-500 mt-0.5">Hanya terlihat dan bisa dihapus oleh Anda</p>
            </div>
        </div>

        {{-- Create Form --}}
        <form method="POST" action="{{ route('categories.store') }}" class="flex flex-wrap items-end gap-3 px-5 py-4 border-b border-slate-100 bg-slate-50/60">
            @csrf
            <div class="flex-1 min-w-40">
                <label class="form-label" for="nama">Nama Kategori</label>
                <input id="nama" type="text" name="nama" required maxlength="100"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Kopi Langganan"
                       class="form-input">
            </div>
            <div class="min-w-36">
                <label class="form-label" for="tipe">Tipe</label>
                <div class="relative">
                    <select id="tipe" name="tipe" required class="form-select pr-8">
                        <option value="pemasukan" @selected(old('tipe') === 'pemasukan')>Pemasukan</option>
                        <option value="pengeluaran" @selected(old('tipe') === 'pengeluaran')>Pengeluaran</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Tambah
            </button>
        </form>

        {{-- List --}}
        <div class="flex-1 divide-y divide-slate-50">
            @forelse ($categories as $category)
                <div class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ $category->tipe === 'pemasukan' ? 'bg-emerald-100' : 'bg-rose-100' }}">
                            @if ($category->tipe === 'pemasukan')
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                            @else
                                <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $category->nama }}</p>
                            <span class="{{ $category->tipe === 'pemasukan' ? 'badge-pemasukan' : 'badge-pengeluaran' }} text-xs">
                                {{ ucfirst($category->tipe) }}
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            data-confirm="Yakin ingin menghapus kategori ini?"
                            class="inline-flex items-center gap-1 text-xs font-semibold text-rose-500 hover:text-rose-700 px-2.5 py-1.5 rounded-lg hover:bg-rose-50 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            @empty
                <div class="px-5 py-12 text-center text-slate-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    <p class="text-sm font-medium">Belum ada kategori kustom</p>
                    <p class="text-xs mt-1">Buat kategori baru di atas</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Default Categories --}}
    <div class="card flex flex-col">
        <div class="card-header">
            <div>
                <h2 class="font-bold text-slate-800">Kategori Bawaan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tersedia untuk semua pengguna, tidak bisa dihapus</p>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 font-medium">
                {{ $bawaan->count() }} kategori
            </span>
        </div>

        <div class="flex-1 divide-y divide-slate-50">
            @foreach ($bawaan as $category)
                <div class="flex items-center justify-between px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ $category->tipe === 'pemasukan' ? 'bg-emerald-100' : 'bg-rose-100' }}">
                            @if ($category->tipe === 'pemasukan')
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                            @else
                                <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $category->nama }}</p>
                            <span class="{{ $category->tipe === 'pemasukan' ? 'badge-pemasukan' : 'badge-pengeluaran' }} text-xs">
                                {{ ucfirst($category->tipe) }}
                            </span>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-lg bg-slate-100 text-slate-400 font-medium">Bawaan</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
