<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'featured' => $this->faker->boolean(),
            'landing' => $this->faker->boolean(),
        ];
    }
}
