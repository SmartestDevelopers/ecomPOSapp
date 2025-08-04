@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>All Products</h1>
            <p class="text-muted">{{ $products->total() }} product{{ $products->total() != 1 ? 's' : '' }} found</p>
        </div>
        <div class="col-md-4">
            {{-- Search Form --}}
            <form method="GET" class="d-flex">
                <input type="text" class="form-control" name="search" 
                       placeholder="Search products..." 
                       value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- Filters --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <select class="form-select" onchange="filterByCategory(this.value)">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-8">
            <div class="btn-group" role="group">
                <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'created_at', 'order' => 'desc'])) }}" 
                   class="btn btn-outline-secondary {{ request('sort') == 'created_at' || !request('sort') ? 'active' : '' }}">
                    Newest First
                </a>
                <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'price', 'order' => 'asc'])) }}" 
                   class="btn btn-outline-secondary {{ request('sort') == 'price' && request('order') == 'asc' ? 'active' : '' }}">
                    Price: Low to High
                </a>
                <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'price', 'order' => 'desc'])) }}" 
                   class="btn btn-outline-secondary {{ request('sort') == 'price' && request('order') == 'desc' ? 'active' : '' }}">
                    Price: High to Low
                </a>
                <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'name', 'order' => 'asc'])) }}" 
                   class="btn btn-outline-secondary {{ request('sort') == 'name' ? 'active' : '' }}">
                    Name A-Z
                </a>
            </div>
        </div>
    </div>

    {{-- Products Grid --}}
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
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
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                    @if($product->stock > 0)
                                        <span class="badge bg-success">In Stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </div>
                                <a href="{{ url('/product/' . $product->slug) }}" class="btn btn-primary w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-search fa-5x text-muted mb-4"></i>
            <h3>No products found</h3>
            @if(request('search'))
                <p class="text-muted">No products found matching "{{ request('search') }}".</p>
                <a href="{{ url('/products') }}" class="btn btn-primary">View All Products</a>
            @elseif(request('category'))
                <p class="text-muted">No products found in the selected category.</p>
                <a href="{{ url('/products') }}" class="btn btn-primary">View All Products</a>
            @else
                <p class="text-muted">No products available at the moment.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
            @endif
        </div>
    @endif
</div>

<script>
function filterByCategory(categorySlug) {
    const url = new URL(window.location.href);
    if (categorySlug) {
        url.searchParams.set('category', categorySlug);
    } else {
        url.searchParams.delete('category');
    }
    window.location.href = url.toString();
}
</script>
@endsection
