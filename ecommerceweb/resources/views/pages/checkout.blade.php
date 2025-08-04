@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Checkout</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('checkout.process') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="4" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="credit_card" value="credit_card" checked>
                                <label class="form-check-label" for="credit_card">
                                    <i class="fas fa-credit-card me-2"></i>Credit Card
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    <i class="fab fa-paypal me-2"></i>PayPal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="cash_on_delivery" value="cash_on_delivery">
                                <label class="form-check-label" for="cash_on_delivery">
                                    <i class="fas fa-money-bill me-2"></i>Cash on Delivery
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            This is a demo checkout. No real payment will be processed.
                        </div>

                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    {{-- Order Items --}}
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0">{{ $item['product']->name }}</h6>
                                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                            </div>
                            <span>${{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                    @endforeach
                    
                    <hr>
                    
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
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>${{ number_format($total >= 50 ? $total : $total + 9.99, 2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i>Back to Cart
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
