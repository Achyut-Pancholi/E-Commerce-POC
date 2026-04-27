<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic gadgets and devices'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Clothing and accessories'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Furniture and gardening tools'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports equipment and accessories'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }
    }
}
