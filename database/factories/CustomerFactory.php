<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => '09' . fake()->randomElement([1, 2, 3, 4]) . fake()->numerify('#######'),
            'backup_phone' => '09' . fake()->randomElement([1, 2, 3, 4]) . fake()->numerify('#######'),
            'first_name'   => fake()->firstName(),
            'last_name'    => fake()->lastName(),
            'email'        => fake()->unique()->email(),
            'password'     => Hash::make('password'),
        ];
    }
}
