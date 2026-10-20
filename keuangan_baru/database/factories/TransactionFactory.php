<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'tipe' => Transaction::TIPE_PENGELUARAN,
            'jumlah' => fake()->randomFloat(2, 10000, 500000),
            'tanggal' => now()->toDateString(),
            'keterangan' => fake()->sentence(3),
        ];
    }

    public function pemasukan(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipe' => Transaction::TIPE_PEMASUKAN,
        ]);
    }

    public function pengeluaran(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipe' => Transaction::TIPE_PENGELUARAN,
        ]);
    }
}
