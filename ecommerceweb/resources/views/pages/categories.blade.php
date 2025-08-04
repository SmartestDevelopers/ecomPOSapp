@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h1>Product Categories</h1>
        <p class="lead">Browse our wide range of product categories</p>
    </div>

    <div class="row">
        @foreach($categories as $category)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card h-100 text-white">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <i class="{{ getCategoryIcon($category->slug) }} fa-4x mb-3"></i>
                        <h4 class="card-title">{{ $category->name }}</h4>
                        <p class="card-text mb-3">{{ $category->product_count }} product{{ $category->product_count != 1 ? 's' : '' }}</p>
                        <div class="mt-auto">
                            <a href="{{ url('/category/' . $category->slug) }}" class="btn btn-light btn-lg">
                                Browse {{ $category->name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($categories->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-tags fa-5x text-muted mb-4"></i>
            <h3>No categories available</h3>
            <p class="text-muted">Categories will appear here once they are added.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
        </div>
    @endif
</div>
@endsection
