@extends('layouts.app')

@section('content')
{{-- Hero Section --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 mb-4">Welcome to ECommerce Store</h1>
                <p class="lead mb-4">Discover amazing products at unbeatable prices. From electronics to fashion, we have everything you need with fast, free shipping on orders over $50.</p>
                <a href="{{ url('/products') }}" class="btn btn-light btn-lg">Shop Now</a>
            </div>
            <div class="col-lg-6">
                <div class="search-form mt-4">
                    <form method="GET" action="{{ url('/search') }}">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" name="query" placeholder="Search for products..." 
                                   value="{{ request('query') }}">
                            <button class="btn btn-light" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories Section --}}
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Shop by Category</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card category-card h-100 text-center">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="{{ getCategoryIcon($category->slug) }} fa-3x mb-3"></i>
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <a href="{{ url('/category/' . $category->slug) }}" class="btn btn-light mt-3">
                            Browse {{ $category->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products Section --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Featured Products</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card product-card h-100">
                    <img src="{{ getProductImage($product->image_path, 300, 200) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}" 
                         style="height: 200px; object-fit: cover;"
                         loading="lazy">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">{{ $product->category_name }}</p>
                        <p class="card-text flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                @if($product->stock > 0)
                                    <span class="badge bg-success">In Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                            <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-primary w-100 mt-2">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ url('/products') }}" class="btn btn-outline-primary btn-lg">View All Products</a>
        </div>
    </div>
</section>

{{-- Features Section --}}
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                <h4>Fast Shipping</h4>
                <p>Free shipping on orders over $50. Get your products delivered quickly and safely.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                <h4>Secure Shopping</h4>
                <p>Your data is protected with industry-standard security measures and encryption.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                <h4>24/7 Support</h4>
                <p>Our customer service team is available around the clock to help with any questions.</p>
            </div>
        </div>
    </div>
</section>
@endsection
