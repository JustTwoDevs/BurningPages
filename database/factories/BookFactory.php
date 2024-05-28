<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(),
            'sinopsis' => $this->faker->realText(),
            'publication_date' => $this->faker->date(),
            'original_language' => $this->faker->text(30),
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => $this->faker->url(),
        ];
    }
}
