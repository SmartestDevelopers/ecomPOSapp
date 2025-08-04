<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = DB::table('products')->where('slug', $slug)->first();
        
        if (!$product) {
            abort(404);
        }

        $category = DB::table('categories')->where('id', $product->category_id)->first();
        
        // Get related products from same category
        $relatedProducts = DB::table('products')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $seoData = [
            'meta_title' => $product->meta_title ?: $product->name . ' - ' . $category->name,
            'meta_description' => $product->meta_description ?: substr(strip_tags($product->description), 0, 160),
            'canonical_url' => url('/product/' . $product->slug),
            'og_type' => 'product',
            'og_image' => $product->image_path ? asset($product->image_path) : null,
        ];

        // Breadcrumbs for structured data
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $category->name, 'url' => url('/category/' . $category->slug)],
            ['name' => $product->name, 'url' => url('/product/' . $product->slug)],
        ];

        return view('pages.product', compact('product', 'category', 'relatedProducts', 'seoData', 'breadcrumbs'));
    }

    public function index(Request $request)
    {
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('categories.slug', $request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('products.name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('products.description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy('products.' . $sortBy, $sortOrder);

        $products = $query->paginate(12);
        $categories = DB::table('categories')->get();

        $seoData = [
            'meta_title' => 'All Products - ECommerce Store',
            'meta_description' => 'Browse our complete collection of quality products including electronics, clothing, books, and more.',
            'canonical_url' => url('/products'),
        ];

        return view('pages.products', compact('products', 'categories', 'seoData'));
    }
}
