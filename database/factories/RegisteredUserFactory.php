<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RegisteredUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rank' => fake()->randomElement(['bronze', 'silver', 'gold']),
            'verified' => fake()->boolean(),
        ];
    }

    public function userId(int $min, int $max): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => fake()->unique()->numberBetween($min, $max),
        ]);
    }
}
