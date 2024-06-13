<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Movie::factory(200)->create();
        Category::factory(30)->create();

        Movie::all()->each(function ($movie) {
            $categories = Category::inRandomOrder()->take(rand(1, 3))->get();
            $movie->categories()->attach($categories);
        });
    }
}
