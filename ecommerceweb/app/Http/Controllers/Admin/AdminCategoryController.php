<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('categories')
            ->select('categories.*', DB::raw('COUNT(products.id) as products_count'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.meta_title', 'categories.meta_description', 'categories.created_at', 'categories.updated_at');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where('categories.name', 'LIKE', '%' . $searchTerm . '%');
        }

        $categories = $query->orderBy('categories.created_at', 'desc')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        
        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('categories')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        DB::table('categories')->insert([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'meta_title' => $request->meta_title ?: $request->name,
            'meta_description' => $request->meta_description ?: 'Browse ' . strtolower($request->name) . ' products at great prices.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function show($id)
    {
        $category = DB::table('categories')
            ->select('categories.*', DB::raw('COUNT(products.id) as products_count'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->where('categories.id', $id)
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.meta_title', 'categories.meta_description', 'categories.created_at', 'categories.updated_at')
            ->first();

        if (!$category) {
            abort(404);
        }

        $products = DB::table('products')
            ->where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.categories.show', compact('category', 'products'));
    }

    public function edit($id)
    {
        $category = DB::table('categories')
            ->select('categories.*', DB::raw('COUNT(products.id) as products_count'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->where('categories.id', $id)
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.meta_title', 'categories.meta_description', 'categories.created_at', 'categories.updated_at')
            ->first();
        
        if (!$category) {
            abort(404);
        }
        
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $category = DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            abort(404);
        }

        $slug = $request->slug ?: Str::slug($request->name);
        
        // Ensure unique slug (exclude current category)
        $originalSlug = $slug;
        $counter = 1;
        while (DB::table('categories')->where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        DB::table('categories')->where('id', $id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'meta_title' => $request->meta_title ?: $request->name,
            'meta_description' => $request->meta_description ?: 'Browse ' . strtolower($request->name) . ' products at great prices.',
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        
        if (!$category) {
            abort(404);
        }

        // Check if category has products
        $hasProducts = DB::table('products')->where('category_id', $id)->exists();
        
        if ($hasProducts) {
        return redirect()->route('admin.categories.index')
            ->with('error', 'Cannot delete category. It has associated products.');
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
