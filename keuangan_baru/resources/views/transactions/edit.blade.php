@extends('layouts.app')

@section('title', 'Edit Catatan')

@section('content')
    @php($isPemasukan = $transaction->tipe === 'pemasukan')

    <div class="mx-auto max-w-lg">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="mb-1 text-xl font-semibold">Edit Catatan</h1>
            <p class="mb-5 text-sm text-slate-500">Perbarui data catatan Anda.</p>

            <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipe" value="{{ $transaction->tipe }}">

                @include('transactions._form', ['transaction' => $transaction])

                <div class="flex gap-2">
                    <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('transactions.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
