<?php

namespace Database\Factories;

use App\Models\Gift;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class GiftFactory extends Factory
{
    protected $model = Gift::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 year');

        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(3),
            'quantity' => $this->faker->randomNumber(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
