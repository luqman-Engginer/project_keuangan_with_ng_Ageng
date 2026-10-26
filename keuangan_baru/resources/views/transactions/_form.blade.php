@php($inputClass = 'form-input')

<div>
    <label class="form-label" for="jumlah">Jumlah (Rp)</label>
    <div class="relative">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-semibold text-sm">Rp</span>
        <input id="jumlah" type="number" name="jumlah" min="1" step="1" required
               value="{{ old('jumlah', $transaction?->jumlah ? (int) $transaction->jumlah : '') }}"
               placeholder="0"
               class="{{ $inputClass }} pl-10">
    </div>
    <p class="mt-1.5 text-xs text-slate-400">Masukkan angka tanpa titik/koma. Contoh: 150000 = Rp 150.000</p>
</div>

<div>
    <label class="form-label" for="tanggal">Tanggal Transaksi</label>
    <input id="tanggal" type="date" name="tanggal" required max="{{ now()->toDateString() }}"
           value="{{ old('tanggal', $transaction?->tanggal?->toDateString() ?? now()->toDateString()) }}"
           class="{{ $inputClass }}">
</div>

<div>
    <label class="form-label" for="category_id">Kategori</label>
    <div class="relative">
        <select id="category_id" name="category_id" required class="{{ $inputClass }} pr-10 appearance-none">
            <option value="">— Pilih kategori —</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $transaction?->category_id) === (string) $category->id)>
                    {{ $category->nama }}{{ $category->isBawaan() ? ' (bawaan)' : ' (kustom)' }}
                </option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
        </div>
    </div>
    <p class="mt-1.5 text-xs text-slate-400">
        Tidak ada kategori yang cocok?
        <a href="{{ route('categories.index') }}" class="text-indigo-600 font-medium hover:underline">Buat kategori baru</a>.
    </p>
</div>

<div>
    <label class="form-label" for="keterangan">Keterangan <span class="font-normal text-slate-400">(opsional)</span></label>
    <input id="keterangan" type="text" name="keterangan" maxlength="255"
           value="{{ old('keterangan', $transaction?->keterangan) }}"
           placeholder="Contoh: Makan siang di kantin"
           class="{{ $inputClass }}">
</div>
