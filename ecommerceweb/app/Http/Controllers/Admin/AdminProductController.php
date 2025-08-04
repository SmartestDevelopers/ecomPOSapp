<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('products.name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('products.description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('categories.name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('products.category_id', $request->category);
        }

        // Filter by stock status
        if ($request->has('stock_status') && $request->stock_status) {
            if ($request->stock_status === 'low') {
                $query->where('products.stock', '<', 5);
            } elseif ($request->stock_status === 'out') {
                $query->where('products.stock', '=', 0);
            }
        }

        $products = $query->orderBy('products.created_at', 'desc')->paginate(15);
        $categories = DB::table('categories')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $slug = Str::slug($request->name);
        
        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('products')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        DB::table('products')->insert([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image_path' => $request->image_path,
            'meta_title' => $request->meta_title ?: $request->name,
            'meta_description' => $request->meta_description ?: Str::limit(strip_tags($request->description), 160),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->where('products.id', $id)
            ->first();

        if (!$product) {
            abort(404);
        }

        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        
        if (!$product) {
            abort(404);
        }
        
        $categories = DB::table('categories')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            abort(404);
        }

        $slug = Str::slug($request->name);
        
        // Ensure unique slug (exclude current product)
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('products')->where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        DB::table('products')->where('id', $id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image_path' => $request->image_path,
            'meta_title' => $request->meta_title ?: $request->name,
            'meta_description' => $request->meta_description ?: Str::limit(strip_tags($request->description), 160),
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        
        if (!$product) {
            abort(404);
        }

        // Check if product has orders
        $hasOrders = DB::table('order_items')->where('product_id', $id)->exists();
        
        if ($hasOrders) {
            return redirect()->route('products.index')
                ->with('error', 'Cannot delete product. It has associated orders.');
        }

        DB::table('products')->where('id', $id)->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
