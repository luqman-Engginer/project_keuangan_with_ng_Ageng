@php($inputClass = 'w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500')

<div>
    <label for="jumlah" class="mb-1 block text-sm font-medium">Jumlah (Rp)</label>
    <input id="jumlah" type="number" name="jumlah" min="1" step="1" required
           value="{{ old('jumlah', $transaction?->jumlah ? (int) $transaction->jumlah : '') }}"
           placeholder="Contoh: 150000" class="{{ $inputClass }}">
    <p class="mt-1 text-xs text-slate-400">Masukkan angka, tanpa titik/koma. Contoh: 150000 = Rp 150.000</p>
</div>

<div>
    <label for="tanggal" class="mb-1 block text-sm font-medium">Tanggal</label>
    <input id="tanggal" type="date" name="tanggal" required max="{{ now()->toDateString() }}"
           value="{{ old('tanggal', $transaction?->tanggal?->toDateString() ?? now()->toDateString()) }}"
           class="{{ $inputClass }}">
</div>

<div>
    <label for="category_id" class="mb-1 block text-sm font-medium">Kategori</label>
    <select id="category_id" name="category_id" required class="{{ $inputClass }}">
        <option value="">— Pilih kategori —</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected((string) old('category_id', $transaction?->category_id) === (string) $category->id)>
                {{ $category->nama }}{{ $category->isBawaan() ? ' (bawaan)' : '' }}
            </option>
        @endforeach
    </select>
    <p class="mt-1 text-xs text-slate-400">
        Tidak ada kategori yang cocok?
        <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline">Buat kategori baru di sini</a>.
    </p>
</div>

<div>
    <label for="keterangan" class="mb-1 block text-sm font-medium">Keterangan <span class="font-normal text-slate-400">(opsional)</span></label>
    <input id="keterangan" type="text" name="keterangan" maxlength="255"
           value="{{ old('keterangan', $transaction?->keterangan) }}"
           placeholder="Contoh: Makan siang di kantin" class="{{ $inputClass }}">
</div>
