@extends('layouts.admin')

@section('title', 'Category Details - ' . $category->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Category Details - {{ $category->name }}</h3>
                    <div>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Category
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Categories
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Category Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Category Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>ID:</strong></td>
                                            <td>{{ $category->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td><strong>{{ $category->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Slug:</strong></td>
                                            <td><code>{{ $category->slug }}</code></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Description:</strong></td>
                                            <td>
                                                @if($category->description)
                                                    {{ $category->description }}
                                                @else
                                                    <span class="text-muted">No description</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y H:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($category->updated_at)->format('M d, Y H:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">SEO Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Meta Title:</strong></td>
                                            <td>
                                                @if($category->meta_title)
                                                    {{ $category->meta_title }}
                                                    <small class="text-muted d-block">{{ strlen($category->meta_title) }} characters</small>
                                                @else
                                                    <span class="text-muted">Not set</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Meta Description:</strong></td>
                                            <td>
                                                @if($category->meta_description)
                                                    {{ $category->meta_description }}
                                                    <small class="text-muted d-block">{{ strlen($category->meta_description) }} characters</small>
                                                @else
                                                    <span class="text-muted">Not set</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Category URL:</strong></td>
                                            <td>
                                                <a href="{{ url('/categories/' . $category->slug) }}" target="_blank" class="text-primary">
                                                    {{ url('/categories/' . $category->slug) }}
                                                    <i class="fas fa-external-link-alt ml-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products in this Category -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Products in this Category</h5>
                                    <div>
                                        <span class="badge badge-info">{{ $products->total() }} Products</span>
                                        <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}" class="btn btn-sm btn-primary ml-2">
                                            <i class="fas fa-plus"></i> Add Product
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($products->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Slug</th>
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
                                                                @if($product->image_path)
                                                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                                                         alt="{{ $product->name }}" 
                                                                         class="img-thumbnail mr-3" 
                                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                                @else
                                                                    <div class="bg-light d-flex align-items-center justify-content-center mr-3" 
                                                                         style="width: 40px; height: 40px;">
                                                                        <i class="fas fa-image text-muted"></i>
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <strong>{{ $product->name }}</strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><code>{{ $product->slug }}</code></td>
                                                        <td><strong>${{ number_format($product->price, 2) }}</strong></td>
                                                        <td>
                                                            @if($product->stock > 10)
                                                                <span class="badge badge-success">{{ $product->stock }}</span>
                                                            @elseif($product->stock > 0)
                                                                <span class="badge badge-warning">{{ $product->stock }}</span>
                                                            @else
                                                                <span class="badge badge-danger">Out of Stock</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($product->stock > 0)
                                                                <span class="badge badge-success">Active</span>
                                                            @else
                                                                <span class="badge badge-secondary">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('M d, Y') }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('admin.products.show', $product->id) }}" 
                                                                   class="btn btn-sm btn-info" title="View">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                                                   class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        @if($products->hasPages())
                                            <div class="d-flex justify-content-center mt-3">
                                                {{ $products->links() }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Products Yet</h5>
                                            <p class="text-muted">This category doesn't have any products.</p>
                                            <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add First Product
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-boxes fa-2x mb-2"></i>
                                    <h4>{{ $products->total() }}</h4>
                                    <p class="mb-0">Total Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h4>{{ $products->where('stock', '>', 0)->count() }}</h4>
                                    <p class="mb-0">In Stock</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <h4>{{ $products->where('stock', '<=', 10)->where('stock', '>', 0)->count() }}</h4>
                                    <p class="mb-0">Low Stock</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-times-circle fa-2x mb-2"></i>
                                    <h4>{{ $products->where('stock', 0)->count() }}</h4>
                                    <p class="mb-0">Out of Stock</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
