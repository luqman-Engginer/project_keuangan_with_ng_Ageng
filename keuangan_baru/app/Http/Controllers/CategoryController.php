<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('categories.index', [
            'categories' => $user->categories()->orderBy('nama')->get(),
            'bawaan' => Category::whereNull('user_id')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama' => [
                'required', 'string', 'max:100',
                Rule::unique('categories')->where(fn ($query) => $query->where('user_id', $user->id)),
            ],
            'tipe' => ['required', Rule::in([Category::TIPE_PEMASUKAN, Category::TIPE_PENGELUARAN])],
        ]);

        $user->categories()->create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori "'.e($validated['nama']).'" berhasil dibuat.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        if ($category->user_id === null || $category->user_id !== $request->user()->id) {
            abort(403, 'Anda hanya bisa menghapus kategori buatan Anda sendiri.');
        }

        if ($category->transactions()->exists()) {
            return back()->withErrors([
                'kategori' => 'Kategori masih digunakan pada catatan transaksi dan tidak bisa dihapus.',
            ]);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
