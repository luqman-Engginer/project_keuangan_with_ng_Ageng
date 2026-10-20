<?php

test('halaman utama mengarahkan tamu ke dashboard dan login', function () {
    $response = $this->get('/');

    $response->assertRedirect('/dashboard');
});
