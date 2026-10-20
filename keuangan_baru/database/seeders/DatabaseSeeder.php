<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_AKTIF,
        ]);

        $this->call(DefaultCategorySeeder::class);
        $this->call(DemoUserSeeder::class);
    }
}
