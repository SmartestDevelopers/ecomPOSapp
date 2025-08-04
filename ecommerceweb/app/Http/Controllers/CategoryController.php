<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function show($slug, Request $request)
    {
        $category = DB::table('categories')->where('slug', $slug)->first();
        
        if (!$category) {
            abort(404);
        }

        $query = DB::table('products')
            ->where('category_id', $category->id);

        // Search within category
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(12);
        $productCount = DB::table('products')->where('category_id', $category->id)->count();

        $seoData = [
            'meta_title' => $category->meta_title ?: $category->name . ' - ECommerce Store',
            'meta_description' => $category->meta_description ?: 'Shop ' . strtolower($category->name) . ' products at great prices with fast shipping.',
            'canonical_url' => url('/category/' . $category->slug),
            'og_type' => 'website',
        ];

        // Breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $category->name, 'url' => url('/category/' . $category->slug)],
        ];

        return view('pages.category', compact('category', 'products', 'productCount', 'seoData', 'breadcrumbs'));
    }

    public function index()
    {
        $categories = DB::table('categories')
            ->select('categories.*', DB::raw('COUNT(products.id) as product_count'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.meta_title', 'categories.meta_description','categories.description', 'categories.created_at', 'categories.updated_at')
            ->orderBy('categories.name')
            ->get();

        $seoData = [
            'meta_title' => 'Product Categories - ECommerce Store',
            'meta_description' => 'Browse our product categories including electronics, clothing, books, home & garden, and sports equipment.',
            'canonical_url' => url('/categories'),
        ];

        return view('pages.categories', compact('categories', 'seoData'));
    }
}
