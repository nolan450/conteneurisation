<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            'movie1.jpg',
            'movie2.jpg',
            'movie3.jpg',
        ];

        return [
            "uid"         => Uuid::uuid4(),
            "name"         => fake()->unique()->company(),
            "description"  => fake()->text(),
            "rate"         => fake()->numberBetween(0, 5),
            "duration"         => fake()->numberBetween(1, 239),
        ];
    }
}
