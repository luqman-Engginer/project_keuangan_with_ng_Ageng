@extends('layouts.app')

@section('title', $tipe === 'pemasukan' ? 'Tambah Pemasukan' : 'Tambah Pengeluaran')

@section('content')
    @php($isPemasukan = $tipe === 'pemasukan')

    <div class="mx-auto max-w-lg">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="mb-1 text-xl font-semibold">
                Tambah Catatan {{ $isPemasukan ? 'Pemasukan' : 'Pengeluaran' }}
            </h1>
            <p class="mb-5 text-sm text-slate-500">Isi data berikut dengan benar.</p>

            <div class="mb-4 flex gap-2 text-sm">
                <a href="{{ route('transactions.create', ['tipe' => 'pemasukan']) }}"
                   class="rounded-md px-3 py-2 font-medium {{ $isPemasukan ? 'bg-green-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Pemasukan
                </a>
                <a href="{{ route('transactions.create', ['tipe' => 'pengeluaran']) }}"
                   class="rounded-md px-3 py-2 font-medium {{ ! $isPemasukan ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Pengeluaran
                </a>
            </div>

            <form method="POST" action="{{ route('transactions.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="tipe" value="{{ $tipe }}">

                @include('transactions._form', ['transaction' => null])

                <div class="flex gap-2">
                    <button type="submit" class="rounded-md {{ $isPemasukan ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-medium text-white">
                        Simpan Catatan
                    </button>
                    <a href="{{ route('transactions.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
