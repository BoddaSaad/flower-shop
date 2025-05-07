<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $price = $this->faker->randomNumber(3);
        $discountType = $this->faker->randomElement(['percentage', 'fixed']);

        if ($discountType === 'fixed') {
            $discount = $this->faker->randomFloat(2, 0, $price);
        } else {
            $discount = $this->faker->randomFloat(2, 0, 100);
        }

        $date = $this->faker->dateTimeBetween('-1 year');

        return [
            'name' => $this->faker->name(),
            'price' => $price,
            'discount' => $discount,
            'discount_type' => $discountType,
            'description' => $this->faker->text(),
            'quantity' => $this->faker->randomNumber(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
