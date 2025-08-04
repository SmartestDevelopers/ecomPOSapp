<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query', '');
        $category = $request->get('category', '');
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $productsQuery = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name');

        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('products.name', 'LIKE', '%' . $query . '%')
                  ->orWhere('products.description', 'LIKE', '%' . $query . '%')
                  ->orWhere('categories.name', 'LIKE', '%' . $query . '%');
            });
        }

        if ($category) {
            $productsQuery->where('categories.slug', $category);
        }

        $productsQuery->orderBy('products.' . $sortBy, $sortOrder);
        $products = $productsQuery->paginate(12)->appends(request()->query());

        $categories = DB::table('categories')->orderBy('name')->get();
        $resultsCount = $products->total();

        // SEO data for search results
        $metaTitle = $query ? 
            "Search Results for '{$query}' - ECommerce Store" : 
            'Search Products - ECommerce Store';
        
        $metaDescription = $query ? 
            "Found {$resultsCount} products matching '{$query}'. Shop electronics, clothing, books and more." :
            'Search our complete product catalog. Find electronics, clothing, books, home decor and sports equipment.';

        $seoData = [
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'canonical_url' => url('/search' . ($query ? '?query=' . urlencode($query) : '')),
            'robots' => $query ? 'noindex,follow' : 'index,follow', // Don't index specific search results
        ];

        return view('pages.search', compact('products', 'categories', 'query', 'category', 'resultsCount', 'seoData'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = DB::table('products')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->select('name', 'slug')
            ->limit(10)
            ->get();

        return response()->json($suggestions);
    }
}
