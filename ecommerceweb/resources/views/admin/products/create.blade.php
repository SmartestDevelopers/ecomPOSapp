@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="category_id" class="form-label">Category *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price ($) *</label>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Stock Quantity *</label>
                            <input type="number" min="0" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock') }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image_path" class="form-label">Image Path</label>
                        <input type="text" class="form-control @error('image_path') is-invalid @enderror" 
                               id="image_path" name="image_path" value="{{ old('image_path') }}"
                               placeholder="e.g., product-images/product-name.jpg">
                        <div class="form-text">
                            Enter the relative path to the product image (optional). 
                            If no image is provided, a placeholder will be used.
                        </div>
                        @error('image_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h6 class="mb-3">SEO Information (Optional)</h6>
                    
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                               id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                               maxlength="255">
                        <div class="form-text">If left empty, product name will be used.</div>
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                  id="meta_description" name="meta_description" rows="3" 
                                  maxlength="500">{{ old('meta_description') }}</textarea>
                        <div class="form-text">If left empty, will be auto-generated from description.</div>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Tips</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        <strong>Product Name:</strong> Use descriptive, SEO-friendly names
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-tag text-info me-2"></i>
                        <strong>Category:</strong> Choose the most relevant category
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-dollar-sign text-success me-2"></i>
                        <strong>Pricing:</strong> Competitive pricing attracts more customers
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-boxes text-primary me-2"></i>
                        <strong>Stock:</strong> Keep adequate inventory levels
                    </li>
                    <li>
                        <i class="fas fa-image text-secondary me-2"></i>
                        <strong>Images:</strong> High-quality images improve conversions
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
