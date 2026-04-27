<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $categories = \App\Models\Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            $name = $faker->unique()->words(3, true);
            \App\Models\Product::create([
                'category_id' => $categories->random()->id,
                'name' => ucwords($name),
                'slug' => \Illuminate\Support\Str::slug($name) . '-' . $i,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 10, 500),
                'stock_quantity' => $faker->numberBetween(10, 100),
                'image_path' => null,
                'is_active' => true,
            ]);
        }
    }
}
