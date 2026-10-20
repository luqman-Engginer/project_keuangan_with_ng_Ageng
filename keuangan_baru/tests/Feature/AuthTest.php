<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('pengguna baru dapat register dengan role user dan status aktif', function () {
    $response = $this->post('/register', [
        'nama' => 'Ahmad Dahlan',
        'email' => 'ahmad@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();

    $user = User::where('email', 'ahmad@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('user');
    expect($user->status)->toBe('aktif');
    // Pastikan password di database ter-hash
    expect(Hash::check('password123', $user->password))->toBeTrue();
    expect($user->password)->not->toBe('password123');
});

test('pengguna dapat login dengan kredensial yang benar', function () {
    $user = User::factory()->create([
        'email' => 'user@example.com',
        'password' => 'rahasia123',
        'status' => 'aktif',
    ]);

    $response = $this->post('/login', [
        'email' => 'user@example.com',
        'password' => 'rahasia123',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('login gagal jika password salah', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => 'rahasia123',
    ]);

    $response = $this->post('/login', [
        'email' => 'user@example.com',
        'password' => 'passwordsalah',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('akun nonaktif tidak bisa login dan menampilkan pesan yang jelas', function () {
    User::factory()->create([
        'email' => 'terblokir@example.com',
        'password' => 'password123',
        'status' => 'nonaktif',
    ]);

    $response = $this->post('/login', [
        'email' => 'terblokir@example.com',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors(['email' => 'Akun Anda sudah dinonaktifkan. Hubungi admin untuk mengaktifkan kembali.']);
    $this->assertGuest();
});

test('pengguna yang dinonaktifkan otomatis logout saat mengakses route terproteksi', function () {
    $user = User::factory()->create([
        'status' => 'nonaktif',
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('pengguna dapat logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

