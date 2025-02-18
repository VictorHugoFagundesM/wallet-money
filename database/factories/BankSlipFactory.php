<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BankSlip>
 */
class BankSlipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();

        return [
            'created_by' => $user->id,
            'name' => fake()->text(50),
            'amount' => fake()->numberBetween(1, 99999),
            'code' => fake()->unique()->numerify('#################################'),
        ];
    }
}
