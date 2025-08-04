<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'meta_title' => 'Electronics - Latest Gadgets & Devices',
                'meta_description' => 'Shop the latest electronics including smartphones, laptops, tablets, and more. Free shipping on orders over $50.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'meta_title' => 'Fashion & Clothing - Trendy Apparel',
                'meta_description' => 'Discover trendy clothing and fashion accessories for men and women. Quality fabrics and affordable prices.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'meta_title' => 'Books - Fiction, Non-Fiction & Educational',
                'meta_description' => 'Browse our extensive collection of books including fiction, non-fiction, educational, and children\'s books.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'meta_title' => 'Home & Garden - Furniture & Decor',
                'meta_description' => 'Transform your home with our furniture, decor, and garden supplies. Create your perfect living space.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'meta_title' => 'Sports & Outdoors - Equipment & Gear',
                'meta_description' => 'Get active with our sports equipment and outdoor gear. Everything you need for fitness and adventure.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
