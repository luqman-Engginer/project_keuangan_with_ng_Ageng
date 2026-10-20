<?php

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;

test('user dapat membuat kategori kustom', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('categories.store'), [
        'nama' => 'Hobi Fotografi',
        'tipe' => Category::TIPE_PENGELUARAN,
    ]);

    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseHas('categories', [
        'nama' => 'Hobi Fotografi',
        'tipe' => Category::TIPE_PENGELUARAN,
        'user_id' => $user->id,
    ]);
});

test('kategori buatan user A tidak muncul di akun user B', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $kategoriA = Category::factory()->create([
        'nama' => 'Koleksi Komik User A',
        'tipe' => Category::TIPE_PENGELUARAN,
        'user_id' => $userA->id,
    ]);

    $response = $this->actingAs($userB)->get(route('categories.index'));

    $response->assertOk();
    $response->assertDontSee('Koleksi Komik User A');
});

test('user A tidak bisa menghapus kategori buatan user B', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $kategoriB = Category::factory()->create([
        'nama' => 'Kategori Rahasia B',
        'tipe' => Category::TIPE_PENGELUARAN,
        'user_id' => $userB->id,
    ]);

    $response = $this->actingAs($userA)->delete(route('categories.destroy', $kategoriB));

    $response->assertForbidden();
    $this->assertDatabaseHas('categories', ['id' => $kategoriB->id]);
});

test('kategori bawaan sistem tidak bisa dihapus', function () {
    $user = User::factory()->create();
    $kategoriBawaan = Category::factory()->create([
        'nama' => 'Gaji Pokok',
        'tipe' => Category::TIPE_PEMASUKAN,
        'user_id' => null,
    ]);

    $response = $this->actingAs($user)->delete(route('categories.destroy', $kategoriBawaan));

    $response->assertForbidden();
    $this->assertDatabaseHas('categories', ['id' => $kategoriBawaan->id]);
});

test('kategori yang masih dipakai dalam transaksi tidak bisa dihapus', function () {
    $user = User::factory()->create();
    $kategori = Category::factory()->create([
        'nama' => 'Kategori Khusus',
        'tipe' => Category::TIPE_PEMASUKAN,
        'user_id' => $user->id,
    ]);

    Transaction::factory()->create([
        'user_id' => $user->id,
        'category_id' => $kategori->id,
        'tipe' => Transaction::TIPE_PEMASUKAN,
        'jumlah' => 100000,
    ]);

    $response = $this->actingAs($user)->delete(route('categories.destroy', $kategori));

    $response->assertSessionHasErrors('kategori');
    $this->assertDatabaseHas('categories', ['id' => $kategori->id]);
});

