@extends('layouts.admin')

@section('title', 'Product Management')
@section('page-title', 'Products')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="mb-0">Product Management</h2>
        <p class="text-muted">Manage your store's product catalog</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Product
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" 
                       placeholder="Search products..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="stock_status" class="form-select">
                    <option value="">All Stock Status</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (< 5)</option>
                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Products ({{ $products->total() }})</h5>
    </div>
    <div class="card-body">
        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                <h5>No products found</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No products found matching your search criteria.
                    @else
                        Start by adding your first product to the store.
                    @endif
                </p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Product
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ getProductImage($product->image_path, 50, 50) }}" 
                                         alt="{{ $product->name }}" 
                                         class="me-3 rounded" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <strong>{{ $product->name }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $product->category_name }}</span>
                            </td>
                            <td>
                                <strong>${{ number_format($product->price, 2) }}</strong>
                            </td>
                            <td>
                                @if($product->stock == 0)
                                    <span class="badge bg-danger">Out of Stock</span>
                                @elseif($product->stock < 5)
                                    <span class="badge bg-warning">{{ $product->stock }} left</span>
                                @else
                                    <span class="badge bg-success">{{ $product->stock }} in stock</span>
                                @endif
                            </td>
                            <td>
                                @if($product->stock > 0)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ date('M d, Y', strtotime($product->created_at)) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product->id) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
