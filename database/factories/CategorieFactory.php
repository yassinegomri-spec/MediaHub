<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    public function definition(): array
    {
        return [
            'nom' => ucfirst(fake()->unique()->words(2, true)),
            'slug' => fake()->unique()->slug(2),
        ];
    }
}