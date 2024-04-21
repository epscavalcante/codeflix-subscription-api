<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->uuid(),
            'document' => fake('pt_BR')->cpf(false),
            'first_name' => fake()->company(),
            'last_name' => fake()->colorName(),
            'email' => fake()->unique()->safeEmail(),
            'birthdate' => fake()->date(),
        ];
    }
}
