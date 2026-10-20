<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('user dapat melihat halaman profil', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('profile.edit'));

    $response->assertOk();
    $response->assertSee($user->nama);
    $response->assertSee($user->email);
});

test('user dapat memperbarui nama dan email', function () {
    $user = User::factory()->create([
        'nama' => 'Nama Lama',
        'email' => 'lama@example.com',
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nama' => 'Nama Baru',
        'email' => 'baru@example.com',
    ]);

    $response->assertRedirect(route('profile.edit'));
    expect($user->fresh()->nama)->toBe('Nama Baru');
    expect($user->fresh()->email)->toBe('baru@example.com');
});

test('user dapat mengganti password', function () {
    $user = User::factory()->create([
        'password' => 'lama12345',
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'nama' => $user->nama,
        'email' => $user->email,
        'password' => 'baru12345',
        'password_confirmation' => 'baru12345',
    ]);

    $response->assertRedirect(route('profile.edit'));
    expect(Hash::check('baru12345', $user->fresh()->password))->toBeTrue();
});

