<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $categories = Category::factory()->count(10)->create();

        $images = [
            "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
            "https://images.pexels.com/photos/5176470/pexels-photo-5176470.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/31776629/pexels-photo-31776629/free-photo-of-beautiful-pink-cherry-blossoms-in-full-bloom.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/4872603/pexels-photo-4872603.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/15119486/pexels-photo-15119486/free-photo-of-close-up-of-a-pink-gerbera.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/31776626/pexels-photo-31776626/free-photo-of-springtime-pink-cherry-blossoms-in-hungary.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/5806696/pexels-photo-5806696.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/12644569/pexels-photo-12644569.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/31776627/pexels-photo-31776627/free-photo-of-beautiful-cherry-blossoms-in-spring-hungary.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/4877068/pexels-photo-4877068.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/31776628/pexels-photo-31776628/free-photo-of-beautiful-blooming-cherry-blossoms-in-hungary.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load",
            "https://images.pexels.com/photos/5828762/pexels-photo-5828762.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load"
        ];

        $categories->each(function (Category $category) use ($images) {


            $category->addMediaFromUrl($images[array_rand($images)])
                ->toMediaCollection();
        });

        $products = Product::factory()->count(100)->create();

        $products->each(function (Product $product) use ($images) {
            $product->categories()->attach(Category::inRandomOrder(3)->value('id'));

            for($i=0; $i<rand(1, 7); $i++){
                $product->addMediaFromUrl($images[array_rand($images)])
                    ->toMediaCollection();
            }
        });
    }
}
