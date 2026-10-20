<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = $user->transactions()->with('category')->latest()->latest('id');

        $tipe = $request->string('tipe')->toString();
        if (in_array($tipe, [Transaction::TIPE_PEMASUKAN, Transaction::TIPE_PENGELUARAN], true)) {
            $query->where('tipe', $tipe);
        }

        $categoryId = $request->integer('kategori');
        if ($categoryId > 0) {
            $query->where('category_id', $categoryId);
        }

        return view('transactions.index', [
            'transactions' => $query->paginate(10)->withQueryString(),
            'categories' => $user->categories()->orderBy('nama')->get()
                ->merge(Category::whereNull('user_id')->orderBy('nama')->get())
                ->sortBy('nama')
                ->values(),
            'filterTipe' => $tipe,
            'filterKategori' => $categoryId,
        ]);
    }

    public function create(Request $request): View
    {
        $user = $request->user();

        $tipe = $request->string('tipe')->toString();
        if (! in_array($tipe, [Transaction::TIPE_PEMASUKAN, Transaction::TIPE_PENGELUARAN], true)) {
            $tipe = Transaction::TIPE_PEMASUKAN;
        }

        return view('transactions.create', [
            'tipe' => $tipe,
            'categories' => $this->categoriesFor($user->id, $tipe),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'tipe' => ['required', Rule::in([Transaction::TIPE_PEMASUKAN, Transaction::TIPE_PENGELUARAN])],
            'jumlah' => ['required', 'numeric', 'gt:0', 'max:9999999999999.99'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
        ]);

        $category = $this->findCategory($user->id, (int) $validated['category_id'], $validated['tipe']);

        if ($validated['tipe'] === Transaction::TIPE_PENGELUARAN && $user->saldo() < (float) $validated['jumlah']) {
            throw ValidationException::withMessages([
                'jumlah' => 'Pengeluaran membuat saldo menjadi negatif. Saldo Anda saat ini '.rupiah($user->saldo()).'.',
            ]);
        }

        $user->transactions()->create([
            'category_id' => $category->id,
            'tipe' => $validated['tipe'],
            'jumlah' => $validated['jumlah'],
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Catatan '.ucfirst($validated['tipe']).' berhasil ditambahkan.');
    }

    public function edit(Request $request, Transaction $transaction): View
    {
        $this->authorizeOwnership($request, $transaction);

        $user = $request->user();

        return view('transactions.edit', [
            'transaction' => $transaction,
            'categories' => $this->categoriesFor($user->id, $transaction->tipe),
        ]);
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->authorizeOwnership($request, $transaction);

        $user = $request->user();

        $validated = $request->validate([
            'tipe' => ['required', Rule::in([Transaction::TIPE_PEMASUKAN, Transaction::TIPE_PENGELUARAN])],
            'jumlah' => ['required', 'numeric', 'gt:0', 'max:9999999999999.99'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
        ]);

        $category = $this->findCategory($user->id, (int) $validated['category_id'], $validated['tipe']);

        if ($validated['tipe'] === Transaction::TIPE_PENGELUARAN) {
            $saldoTanpaTransaksiIni = $user->saldo() + (float) $transaction->jumlah;

            if ($saldoTanpaTransaksiIni < (float) $validated['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Pengeluaran membuat saldo menjadi negatif. Maksimal '.rupiah($saldoTanpaTransaksiIni).'.',
                ]);
            }
        }

        $transaction->update([
            'category_id' => $category->id,
            'tipe' => $validated['tipe'],
            'jumlah' => $validated['jumlah'],
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->authorizeOwnership($request, $transaction);

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Catatan berhasil dihapus.');
    }

    public function createTopUp(): View
    {
        return view('transactions.topup');
    }

    public function topUp(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'jumlah' => ['required', 'numeric', 'gt:0', 'max:9999999999999.99'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $category = Category::firstOrCreate(
            ['nama' => 'Isi Saldo', 'tipe' => Transaction::TIPE_PEMASUKAN, 'user_id' => null],
        );

        $user->transactions()->create([
            'category_id' => $category->id,
            'tipe' => Transaction::TIPE_PEMASUKAN,
            'jumlah' => $validated['jumlah'],
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'] ?? 'Isi saldo',
        ]);

        return redirect()->route('dashboard')->with('success', 'Isi saldo berhasil. Saldo Anda sekarang '.rupiah($user->saldo()).'.');
    }

    /**
     * Pastikan transaksi benar-benar milik user yang sedang login.
     */
    private function authorizeOwnership(Request $request, Transaction $transaction): void
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak punya akses ke data ini.');
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Category>
     */
    private function categoriesFor(int $userId, string $tipe)
    {
        return Category::query()
            ->where(function ($query) use ($userId) {
                $query->whereNull('user_id')->orWhere('user_id', $userId);
            })
            ->where('tipe', $tipe)
            ->orderBy('nama')
            ->get();
    }

    private function findCategory(int $userId, int $categoryId, string $tipe): Category
    {
        $category = Category::query()
            ->where('tipe', $tipe)
            ->where(function ($query) use ($userId) {
                $query->whereNull('user_id')->orWhere('user_id', $userId);
            })
            ->find($categoryId);

        if ($category === null) {
            throw ValidationException::withMessages([
                'category_id' => 'Kategori tidak ditemukan atau tidak sesuai dengan jenis transaksi.',
            ]);
        }

        return $category;
    }
}
