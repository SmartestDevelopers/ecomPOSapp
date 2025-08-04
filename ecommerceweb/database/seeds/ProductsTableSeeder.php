<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            // Electronics Category (ID: 1)
            [
                'name' => 'iPhone 12 Pro',
                'slug' => 'iphone-12-pro',
                'description' => 'Latest iPhone with A14 Bionic chip, Pro camera system, and 5G connectivity. Experience the power of Apple\'s most advanced smartphone.',
                'price' => 999.99,
                'stock' => 50,
                'category_id' => 1,
                'image_path' => 'products/iphone-12-pro.jpg',
                'meta_title' => 'iPhone 12 Pro - Apple Smartphone | Buy Online',
                'meta_description' => 'Buy iPhone 12 Pro with A14 Bionic chip, Pro camera system, and 5G. Free shipping and warranty included.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samsung Galaxy S21',
                'slug' => 'samsung-galaxy-s21',
                'description' => 'Flagship Android smartphone with 120Hz display, triple camera setup, and premium design.',
                'price' => 799.99,
                'stock' => 30,
                'category_id' => 1,
                'image_path' => 'products/samsung-galaxy-s21.jpg',
                'meta_title' => 'Samsung Galaxy S21 - Android Smartphone | Best Price',
                'meta_description' => 'Samsung Galaxy S21 with 120Hz display and triple camera. Get the best price with free shipping.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MacBook Air M1',
                'slug' => 'macbook-air-m1',
                'description' => 'Apple MacBook Air with M1 chip delivers incredible performance and all-day battery life.',
                'price' => 1299.99,
                'stock' => 25,
                'category_id' => 1,
                'image_path' => 'products/macbook-air-m1.jpg',
                'meta_title' => 'MacBook Air M1 - Apple Laptop | Fast Delivery',
                'meta_description' => 'MacBook Air with M1 chip offers incredible performance and battery life. Order now with fast delivery.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Clothing Category (ID: 2)
            [
                'name' => 'Classic White T-Shirt',
                'slug' => 'classic-white-t-shirt',
                'description' => 'Premium cotton white t-shirt perfect for casual wear. Comfortable fit and durable material.',
                'price' => 24.99,
                'stock' => 100,
                'category_id' => 2,
                'image_path' => 'products/white-t-shirt.jpg',
                'meta_title' => 'Classic White T-Shirt - Premium Cotton | Comfortable Fit',
                'meta_description' => 'Premium cotton white t-shirt with comfortable fit. Perfect for casual wear. Available in all sizes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Denim Jeans',
                'slug' => 'denim-jeans',
                'description' => 'High-quality denim jeans with modern fit. Available in multiple sizes and washes.',
                'price' => 79.99,
                'stock' => 75,
                'category_id' => 2,
                'image_path' => 'products/denim-jeans.jpg',
                'meta_title' => 'Denim Jeans - High Quality | Modern Fit',
                'meta_description' => 'High-quality denim jeans with modern fit. Multiple sizes and washes available. Shop now!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Books Category (ID: 3)
            [
                'name' => 'The Great Gatsby',
                'slug' => 'the-great-gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald. A masterpiece of 20th-century literature.',
                'price' => 12.99,
                'stock' => 200,
                'category_id' => 3,
                'image_path' => 'products/great-gatsby.jpg',
                'meta_title' => 'The Great Gatsby by F. Scott Fitzgerald | Classic Novel',
                'meta_description' => 'Read the classic American novel The Great Gatsby by F. Scott Fitzgerald. Available in paperback and hardcover.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'JavaScript: The Good Parts',
                'slug' => 'javascript-the-good-parts',
                'description' => 'Essential guide to JavaScript programming by Douglas Crockford. Perfect for developers.',
                'price' => 34.99,
                'stock' => 85,
                'category_id' => 3,
                'image_path' => 'products/javascript-book.jpg',
                'meta_title' => 'JavaScript: The Good Parts - Programming Book | Developer Guide',
                'meta_description' => 'Learn JavaScript programming with this essential guide by Douglas Crockford. Perfect for developers.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Home & Garden Category (ID: 4)
            [
                'name' => 'Modern Coffee Table',
                'slug' => 'modern-coffee-table',
                'description' => 'Stylish modern coffee table made from premium oak wood. Perfect centerpiece for your living room.',
                'price' => 299.99,
                'stock' => 15,
                'category_id' => 4,
                'image_path' => 'products/coffee-table.jpg',
                'meta_title' => 'Modern Coffee Table - Oak Wood | Living Room Furniture',
                'meta_description' => 'Stylish modern coffee table made from premium oak wood. Perfect for your living room decor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Sports & Outdoors Category (ID: 5)
            [
                'name' => 'Yoga Mat Premium',
                'slug' => 'yoga-mat-premium',
                'description' => 'High-quality non-slip yoga mat perfect for all types of yoga practice. Eco-friendly materials.',
                'price' => 49.99,
                'stock' => 60,
                'category_id' => 5,
                'image_path' => 'products/yoga-mat.jpg',
                'meta_title' => 'Premium Yoga Mat - Non-Slip | Eco-Friendly Materials',
                'meta_description' => 'High-quality non-slip yoga mat made from eco-friendly materials. Perfect for all yoga practices.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
