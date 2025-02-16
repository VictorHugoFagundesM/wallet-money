<?php

namespace Database\Seeders;

use App\Models\BankSlip;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create([
            'password' => Hash::make('password'),
            'balance' => fake()->numberBetween(1, 99999),
        ]);

        User::insert([
            'name' => 'Test User',
            'email' => 'test1@example.com',
            'balance' => fake()->numberBetween(1, 99999),
            'account_number' => '56248567-002',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $this->call([
            BankSlipSeeder::class,
            RefundStatusSeeder::class,
            TransactionTypeSeeder::class,
            TransactionSeeder::class,
            RefundSeeder::class,
        ]);

    }
}
