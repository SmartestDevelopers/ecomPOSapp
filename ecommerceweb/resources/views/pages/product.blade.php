@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $breadcrumb)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6">
            {{-- Product Image --}}
            <img src="{{ getProductImage($product->image_path, 600, 400) }}" 
                 class="img-fluid rounded" 
                 alt="{{ $product->name }}" 
                 style="width: 100%; height: 400px; object-fit: cover;"
                 loading="lazy">
        </div>
        
        <div class="col-md-6">
            <h1 class="h2 mb-3">{{ $product->name }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-secondary">{{ $category->name }}</span>
                @if($product->stock > 0)
                    <span class="badge bg-success ms-2">In Stock ({{ $product->stock }} available)</span>
                @else
                    <span class="badge bg-danger ms-2">Out of Stock</span>
                @endif
            </div>
            
            <div class="mb-4">
                <span class="h3 text-primary">${{ number_format($product->price, 2) }}</span>
            </div>
            
            <div class="mb-4">
                <h5>Description</h5>
                <p>{{ $product->description }}</p>
            </div>
            
            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-auto">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" 
                                       value="1" min="1" max="{{ $product->stock }}" style="width: 80px;">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>
                        <i class="fas fa-times me-2"></i>Out of Stock
                    </button>
                @endif
            @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a> to add items to cart
                </div>
            @endauth
        </div>
    </div>
    
    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <h3>Related Products</h3>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card product-card h-100">
                            <img src="{{ getProductImage($relatedProduct->image_path, 300, 200) }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedProduct->name }}" 
                                 style="height: 200px; object-fit: cover;"
                                 loading="lazy">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                <p class="card-text flex-grow-1">{{ Str::limit($relatedProduct->description, 80) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h6 text-primary mb-0">${{ number_format($relatedProduct->price, 2) }}</span>
                                        @if($relatedProduct->stock > 0)
                                            <span class="badge bg-success">In Stock</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </div>
                                    <a href="{{ url('/product/' . $relatedProduct->slug) }}" class="btn btn-outline-primary w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
