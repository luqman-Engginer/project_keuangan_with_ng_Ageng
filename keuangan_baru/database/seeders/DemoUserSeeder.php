<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $budi = User::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password',
            'role' => User::ROLE_USER,
            'status' => User::STATUS_AKTIF,
        ]);

        $siti = User::create([
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => 'password',
            'role' => User::ROLE_USER,
            'status' => User::STATUS_AKTIF,
        ]);

        $kategoriBudi = Category::create(['nama' => 'Jajan Manual', 'tipe' => Category::TIPE_PENGELUARAN, 'user_id' => $budi->id]);

        $isiSaldo = Category::where('nama', 'Isi Saldo')->where('tipe', Category::TIPE_PEMASUKAN)->first();
        $gaji = Category::where('nama', 'Gaji')->where('tipe', Category::TIPE_PEMASUKAN)->first();
        $makan = Category::where('nama', 'Makan')->where('tipe', Category::TIPE_PENGELUARAN)->first();
        $transportasi = Category::where('nama', 'Transportasi')->where('tipe', Category::TIPE_PENGELUARAN)->first();

        $budi->transactions()->create([
            'category_id' => $isiSaldo->id,
            'tipe' => Transaction::TIPE_PEMASUKAN,
            'jumlah' => 500000,
            'tanggal' => now()->subDays(7)->toDateString(),
            'keterangan' => 'Isi saldo awal',
        ]);

        $budi->transactions()->create([
            'category_id' => $gaji->id,
            'tipe' => Transaction::TIPE_PEMASUKAN,
            'jumlah' => 3000000,
            'tanggal' => now()->subDays(5)->toDateString(),
            'keterangan' => 'Gaji bulanan',
        ]);

        $budi->transactions()->create([
            'category_id' => $makan->id,
            'tipe' => Transaction::TIPE_PENGELUARAN,
            'jumlah' => 150000,
            'tanggal' => now()->subDays(3)->toDateString(),
            'keterangan' => 'Makan siang',
        ]);

        $budi->transactions()->create([
            'category_id' => $transportasi->id,
            'tipe' => Transaction::TIPE_PENGELUARAN,
            'jumlah' => 50000,
            'tanggal' => now()->subDay()->toDateString(),
            'keterangan' => 'Bensin',
        ]);

        $budi->transactions()->create([
            'category_id' => $kategoriBudi->id,
            'tipe' => Transaction::TIPE_PENGELUARAN,
            'jumlah' => 25000,
            'tanggal' => now()->toDateString(),
            'keterangan' => 'Jajan manual',
        ]);

        $siti->transactions()->create([
            'category_id' => $isiSaldo->id,
            'tipe' => Transaction::TIPE_PEMASUKAN,
            'jumlah' => 200000,
            'tanggal' => now()->subDays(2)->toDateString(),
            'keterangan' => 'Isi saldo awal',
        ]);

        $siti->transactions()->create([
            'category_id' => $makan->id,
            'tipe' => Transaction::TIPE_PENGELUARAN,
            'jumlah' => 75000,
            'tanggal' => now()->subDay()->toDateString(),
            'keterangan' => 'Sarapan',
        ]);
    }
}
