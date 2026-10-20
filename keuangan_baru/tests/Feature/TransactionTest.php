<?php

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;

test('dashboard menampilkan total pemasukan, total pengeluaran, dan saldo dengan benar', function () {
    $user = User::factory()->create();
    $kategoriPemasukan = Category::factory()->create(['tipe' => Category::TIPE_PEMASUKAN]);
    $kategoriPengeluaran = Category::factory()->create(['tipe' => Category::TIPE_PENGELUARAN]);

    Transaction::factory()->create([
        'user_id' => $user->id,
        'category_id' => $kategoriPemasukan->id,
        'tipe' => Transaction::TIPE_PEMASUKAN,
        'jumlah' => 1000000,
    ]);

    Transaction::factory()->create([
        'user_id' => $user->id,
        'category_id' => $kategoriPengeluaran->id,
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'jumlah' => 350000,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Rp 1.000.000');
    $response->assertSee('Rp 350.000');
    $response->assertSee('Rp 650.000');
});

test('isi saldo menambah saldo dan total pemasukan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('topup.store'), [
        'jumlah' => 500000,
        'tanggal' => now()->toDateString(),
        'keterangan' => 'Top up uang saku',
    ]);

    $response->assertRedirect(route('dashboard'));
    expect($user->fresh()->saldo())->toBe(500000.0);

    $this->assertDatabaseHas('transactions', [
        'user_id' => $user->id,
        'tipe' => Transaction::TIPE_PEMASUKAN,
        'jumlah' => 500000,
        'keterangan' => 'Top up uang saku',
    ]);
});

test('tambah pengeluaran yang membuat saldo negatif dicegah oleh server', function () {
    $user = User::factory()->create();
    $kategori = Category::factory()->create(['tipe' => Category::TIPE_PENGELUARAN]);

    // Saldo awal = 0
    $response = $this->actingAs($user)->post(route('transactions.store'), [
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'jumlah' => 50000,
        'tanggal' => now()->toDateString(),
        'category_id' => $kategori->id,
        'keterangan' => 'Beli buku',
    ]);

    $response->assertSessionHasErrors('jumlah');
    expect($user->fresh()->saldo())->toBe(0.0);
    expect(Transaction::count())->toBe(0);
});

test('user A tidak bisa melihat halaman edit transaksi milik user B', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $transaksiUserB = Transaction::factory()->create([
        'user_id' => $userB->id,
    ]);

    $response = $this->actingAs($userA)->get(route('transactions.edit', $transaksiUserB));

    $response->assertForbidden();
});

test('user A tidak bisa mengupdate transaksi milik user B', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $kategori = Category::factory()->create(['tipe' => Transaction::TIPE_PEMASUKAN]);
    $transaksiUserB = Transaction::factory()->create([
        'user_id' => $userB->id,
        'tipe' => Transaction::TIPE_PEMASUKAN,
        'jumlah' => 100000,
        'category_id' => $kategori->id,
    ]);

    $response = $this->actingAs($userA)->put(route('transactions.update', $transaksiUserB), [
        'tipe' => Transaction::TIPE_PEMASUKAN,
        'jumlah' => 999999,
        'tanggal' => now()->toDateString(),
        'category_id' => $kategori->id,
    ]);

    $response->assertForbidden();
    expect($transaksiUserB->fresh()->jumlah)->toBe('100000.00');
});

test('user A tidak bisa menghapus transaksi milik user B', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $transaksiUserB = Transaction::factory()->create([
        'user_id' => $userB->id,
    ]);

    $response = $this->actingAs($userA)->delete(route('transactions.destroy', $transaksiUserB));

    $response->assertForbidden();
    $this->assertDatabaseHas('transactions', ['id' => $transaksiUserB->id]);
});

test('edit dan hapus transaksi memperbarui saldo dan total dengan benar', function () {
    $user = User::factory()->create();
    $kategoriPemasukan = Category::factory()->create(['tipe' => Category::TIPE_PEMASUKAN]);
    $kategoriPengeluaran = Category::factory()->create(['tipe' => Category::TIPE_PENGELUARAN]);

    // Top up 1.000.000
    Transaction::factory()->create([
        'user_id' => $user->id,
        'category_id' => $kategoriPemasukan->id,
        'tipe' => Transaction::TIPE_PEMASUKAN,
        'jumlah' => 1000000,
    ]);

    // Pengeluaran awal 200.000
    $pengeluaran = Transaction::factory()->create([
        'user_id' => $user->id,
        'category_id' => $kategoriPengeluaran->id,
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'jumlah' => 200000,
    ]);

    expect($user->fresh()->saldo())->toBe(800000.0);

    // Edit pengeluaran menjadi 300.000
    $response = $this->actingAs($user)->put(route('transactions.update', $pengeluaran), [
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'jumlah' => 300000,
        'tanggal' => now()->toDateString(),
        'category_id' => $kategoriPengeluaran->id,
        'keterangan' => 'Pengeluaran diubah',
    ]);

    $response->assertRedirect(route('transactions.index'));
    expect($user->fresh()->saldo())->toBe(700000.0);

    // Hapus pengeluaran
    $response = $this->actingAs($user)->delete(route('transactions.destroy', $pengeluaran));
    $response->assertRedirect(route('transactions.index'));

    expect($user->fresh()->saldo())->toBe(1000000.0);
    $this->assertDatabaseMissing('transactions', ['id' => $pengeluaran->id]);
});

test('penghapusan pemasukan dicegah jika membuat saldo menjadi negatif', function () {
    $user = User::factory()->create();
    $kategoriPemasukan = Category::factory()->create(['tipe' => Category::TIPE_PEMASUKAN]);
    $kategoriPengeluaran = Category::factory()->create(['tipe' => Category::TIPE_PENGELUARAN]);

    $pemasukan = Transaction::factory()->create([
        'user_id' => $user->id,
        'category_id' => $kategoriPemasukan->id,
        'tipe' => Transaction::TIPE_PEMASUKAN,
        'jumlah' => 500000,
    ]);

    Transaction::factory()->create([
        'user_id' => $user->id,
        'category_id' => $kategoriPengeluaran->id,
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'jumlah' => 400000,
    ]);

    // Saldo = 100.000. Jika pemasukan 500.000 dihapus, saldo akan jadi -400.000
    $response = $this->actingAs($user)->delete(route('transactions.destroy', $pemasukan));

    $response->assertSessionHasErrors('transaksi');
    $this->assertDatabaseHas('transactions', ['id' => $pemasukan->id]);
    expect($user->fresh()->saldo())->toBe(100000.0);
});

test('user hanya melihat transaksinya sendiri di daftar riwayat dan filter berjalan', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $katMakan = Category::factory()->create(['nama' => 'Makan', 'tipe' => Category::TIPE_PENGELUARAN]);
    $katBensin = Category::factory()->create(['nama' => 'Bensin', 'tipe' => Category::TIPE_PENGELUARAN]);

    Transaction::factory()->create([
        'user_id' => $userA->id,
        'category_id' => $katMakan->id,
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'keterangan' => 'Nasi Padang User A',
        'jumlah' => 25000,
    ]);

    Transaction::factory()->create([
        'user_id' => $userA->id,
        'category_id' => $katBensin->id,
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'keterangan' => 'Bensin Pertalite User A',
        'jumlah' => 50000,
    ]);

    Transaction::factory()->create([
        'user_id' => $userB->id,
        'category_id' => $katMakan->id,
        'tipe' => Transaction::TIPE_PENGELUARAN,
        'keterangan' => 'Rahasia User B',
        'jumlah' => 75000,
    ]);

    // Buka tanpa filter: melihat punya sendiri, tidak melihat punya User B
    $response = $this->actingAs($userA)->get(route('transactions.index'));
    $response->assertOk();
    $response->assertSee('Nasi Padang User A');
    $response->assertSee('Bensin Pertalite User A');
    $response->assertDontSee('Rahasia User B');

    // Filter kategori Makan
    $responseFilter = $this->actingAs($userA)->get(route('transactions.index', ['kategori' => $katMakan->id]));
    $responseFilter->assertOk();
    $responseFilter->assertSee('Nasi Padang User A');
    $responseFilter->assertDontSee('Bensin Pertalite User A');
});
