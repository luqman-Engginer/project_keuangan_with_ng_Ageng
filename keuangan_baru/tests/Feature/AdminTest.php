<?php

use App\Models\User;

test('user biasa membuka halaman admin ditolak dengan status 403', function () {
    $userBiasa = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($userBiasa)->get(route('admin.users.index'));

    $response->assertForbidden();
});

test('tamu yang belum login diarahkan ke login saat membuka halaman admin', function () {
    $response = $this->get(route('admin.users.index'));

    $response->assertRedirect(route('login'));
});

test('admin dapat melihat daftar user', function () {
    $admin = User::factory()->admin()->create();
    $user1 = User::factory()->create(['nama' => 'Budi User Satu']);
    $user2 = User::factory()->create(['nama' => 'Citra User Dua']);

    $response = $this->actingAs($admin)->get(route('admin.users.index'));

    $response->assertOk();
    $response->assertSee('Budi User Satu');
    $response->assertSee('Citra User Dua');
});

test('admin dapat menonaktifkan dan mengaktifkan akun user', function () {
    $admin = User::factory()->admin()->create();
    $targetUser = User::factory()->create(['status' => 'aktif']);

    // Nonaktifkan
    $response = $this->actingAs($admin)->patch(route('admin.users.toggle-status', $targetUser));
    $response->assertRedirect(route('admin.users.index'));
    expect($targetUser->fresh()->status)->toBe('nonaktif');

    // Aktifkan kembali
    $response = $this->actingAs($admin)->patch(route('admin.users.toggle-status', $targetUser));
    $response->assertRedirect(route('admin.users.index'));
    expect($targetUser->fresh()->status)->toBe('aktif');
});

test('admin tidak dapat menonaktifkan akunnya sendiri', function () {
    $admin = User::factory()->admin()->create(['status' => 'aktif']);

    $response = $this->actingAs($admin)->patch(route('admin.users.toggle-status', $admin));

    $response->assertSessionHasErrors('user');
    expect($admin->fresh()->status)->toBe('aktif');
});

test('admin dapat menghapus akun user', function () {
    $admin = User::factory()->admin()->create();
    $targetUser = User::factory()->create();

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $targetUser));

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
});

test('admin tidak dapat menghapus akunnya sendiri', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

    $response->assertSessionHasErrors('user');
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

