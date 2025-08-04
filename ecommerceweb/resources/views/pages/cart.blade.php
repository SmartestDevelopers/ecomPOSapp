@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(empty($cartItems))
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Add some products to your cart to see them here.</p>
            <a href="{{ url('/products') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="row align-items-center border-bottom py-3">
                                <div class="col-md-2">
                                    <img src="{{ getProductImage($item['product']->image_path, 80, 80) }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $item['product']->name }}"
                                         style="height: 80px; width: 80px; object-fit: cover;"
                                         loading="lazy">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                    <p class="text-muted small mb-0">${{ number_format($item['product']->price, 2) }} each</p>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm" style="max-width: 120px;">
                                            <input type="number" class="form-control" name="quantity" 
                                                   value="{{ $item['quantity'] }}" min="1" 
                                                   max="{{ $item['product']->stock }}">
                                            <button type="submit" class="btn btn-outline-secondary">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <strong>${{ number_format($item['subtotal'], 2) }}</strong>
                                </div>
                                <div class="col-md-1">
                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Remove this item from cart?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="mt-3">
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary" 
                                        onclick="return confirm('Clear entire cart?')">
                                    <i class="fas fa-trash me-2"></i>Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>
                                @if($total >= 50)
                                    <span class="text-success">Free</span>
                                @else
                                    $9.99
                                @endif
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>${{ number_format($total >= 50 ? $total : $total + 9.99, 2) }}</strong>
                        </div>
                        
                        @if($total < 50)
                            <div class="alert alert-info small">
                                <i class="fas fa-info-circle me-1"></i>
                                Add ${{ number_format(50 - $total, 2) }} more for free shipping!
                            </div>
                        @endif
                        
                        <a href="{{ route('checkout') }}" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                        </a>
                        <a href="{{ url('/products') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
