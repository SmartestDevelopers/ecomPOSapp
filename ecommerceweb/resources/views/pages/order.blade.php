@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Order #{{ $order->id }}</h1>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Order Date:</strong> {{ $order->created_at }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($order->status === 'pending') bg-warning
                            @elseif($order->status === 'processing') bg-info
                            @elseif($order->status === 'shipped') bg-primary
                            @elseif($order->status === 'delivered') bg-success
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</p>
                    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body">
                    @if($orderItems->isEmpty())
                        <p>No items found for this order.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ getProductImage($item->image_path, 60, 60) }}" 
                                                     alt="{{ $item->name }}" 
                                                     class="me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <a href="{{ url('/product/' . $item->slug) }}">{{ $item->name }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    @php
                        $subtotal = $orderItems->sum(function($item) {
                            return $item->price * $item->quantity;
                        });
                        $shipping = $subtotal < 50 ? 9.99 : 0;
                    @endphp
                    
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <span>
                            @if($shipping > 0)
                                ${{ number_format($shipping, 2) }}
                            @else
                                Free
                            @endif
                        </span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span>${{ number_format($order->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">← Back to Orders</a>
            </div>
        </div>
    </div>
</div>
@endsection
