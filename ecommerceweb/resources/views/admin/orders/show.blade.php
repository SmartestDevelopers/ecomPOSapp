@extends('layouts.admin')

@section('title', 'Order Details #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Order Details #{{ $order->id }}</h3>
                    <div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Update Status
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
                        <!-- Order Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Order Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Order ID:</strong></td>
                                            <td>#{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge badge-info">Processing</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge badge-success">Completed</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge badge-danger">Cancelled</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Order Date:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y H:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Amount:</strong></td>
                                            <td><strong class="text-success">${{ number_format($order->total_price, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Customer Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $order->user_name ?? 'Guest Customer' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $order->user_email ?? $order->email ?? 'N/A' }}</td>
                                        </tr>
                                        @if($order->shipping_address)
                                        <tr>
                                            <td><strong>Shipping Address:</strong></td>
                                            <td>{{ $order->shipping_address }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Order Items</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th class="text-right">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $totalItems = 0; @endphp
                                                @forelse($orderItems as $item)
                                                @php $totalItems += $item->quantity; @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($item->product_image)
                                                                <img src="{{ asset('storage/' . $item->product_image) }}" 
                                                                     alt="{{ $item->product_name }}" 
                                                                     class="img-thumbnail me-3" 
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-light d-flex align-items-center justify-content-center me-3" 
                                                                     style="width: 50px; height: 50px;">
                                                                    <i class="fas fa-image text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <strong>{{ $item->product_name }}</strong>
                                                                @if($item->product_slug)
                                                                    <br><small class="text-muted">{{ $item->product_slug }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $item->quantity }}</span>
                                                    </td>
                                                    <td class="text-right">
                                                        <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">
                                                        No items found for this order.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            @if($orderItems->count() > 0)
                                            <tfoot class="thead-light">
                                                <tr>
                                                    <th colspan="2">Total Items: {{ $totalItems }}</th>
                                                    <th>{{ $orderItems->count() }} Products</th>
                                                    <th class="text-right">
                                                        <strong class="text-success">${{ number_format($order->total_price, 2) }}</strong>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Timeline (if needed) -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Order Status Updates</h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Order Placed</h6>
                                                <p class="timeline-description">
                                                    Order was successfully placed
                                                </p>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y H:i A') }}
                                                </small>
                                            </div>
                                        </div>
                                        
                                        @if($order->status != 'pending')
                                        <div class="timeline-item">
                                            <div class="timeline-marker 
                                                @if($order->status == 'cancelled') bg-danger 
                                                @else bg-info @endif">
                                            </div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Status: {{ ucfirst($order->status) }}</h6>
                                                <p class="timeline-description">
                                                    Order status updated to {{ $order->status }}
                                                </p>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($order->updated_at)->format('M d, Y H:i A') }}
                                                </small>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
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

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -23px;
    top: 20px;
    height: calc(100% - 10px);
    width: 2px;
    background-color: #e9ecef;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 20px;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-description {
    margin-bottom: 5px;
    color: #6c757d;
}
</style>
@endpush
