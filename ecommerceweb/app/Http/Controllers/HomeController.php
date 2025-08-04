<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (latest 8 products)
        $featuredProducts = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->orderBy('products.created_at', 'desc')
            ->limit(8)
            ->get();

        // Get categories for navigation
        $categories = DB::table('categories')
            ->orderBy('name')
            ->get();

        $seoData = [
            'meta_title' => 'ECommerce Store - Quality Products at Best Prices',
            'meta_description' => 'Shop quality electronics, clothing, books, home & garden, and sports products at unbeatable prices. Free shipping on orders over $50.',
            'meta_keywords' => 'ecommerce, online shopping, electronics, clothing, books, home decor, sports equipment',
            'canonical_url' => url('/'),
            'og_type' => 'website',
        ];

        return view('pages.home', compact('featuredProducts', 'categories', 'seoData'));
    }

    public function about()
    {
        $seoData = [
            'meta_title' => 'About Us - ECommerce Store',
            'meta_description' => 'Learn about our mission to provide quality products at affordable prices with excellent customer service.',
            'canonical_url' => url('/about'),
        ];

        return view('pages.about', compact('seoData'));
    }
}
