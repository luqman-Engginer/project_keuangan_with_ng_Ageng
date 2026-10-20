<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DefaultCategorySeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama' => 'Gaji', 'tipe' => Category::TIPE_PEMASUKAN],
            ['nama' => 'Uang Saku', 'tipe' => Category::TIPE_PEMASUKAN],
            ['nama' => 'Bonus', 'tipe' => Category::TIPE_PEMASUKAN],
            ['nama' => 'Isi Saldo', 'tipe' => Category::TIPE_PEMASUKAN],
            ['nama' => 'Makan', 'tipe' => Category::TIPE_PENGELUARAN],
            ['nama' => 'Transportasi', 'tipe' => Category::TIPE_PENGELUARAN],
            ['nama' => 'Belanja', 'tipe' => Category::TIPE_PENGELUARAN],
            ['nama' => 'Pendidikan', 'tipe' => Category::TIPE_PENGELUARAN],
            ['nama' => 'Hiburan', 'tipe' => Category::TIPE_PENGELUARAN],
            ['nama' => 'Tagihan', 'tipe' => Category::TIPE_PENGELUARAN],
            ['nama' => 'Lainnya', 'tipe' => Category::TIPE_PEMASUKAN],
            ['nama' => 'Lainnya', 'tipe' => Category::TIPE_PENGELUARAN],
        ];

        foreach ($kategori as $item) {
            Category::firstOrCreate(
                ['nama' => $item['nama'], 'tipe' => $item['tipe'], 'user_id' => null],
            );
        }
    }
}
