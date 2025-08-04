@extends('layouts.admin')

@section('title', 'Update Order Status #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Update Order Status #{{ $order->id }}</h3>
                    <div>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
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

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Order Summary -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Order Summary</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Order ID:</strong></td>
                                            <td>#{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Customer:</strong></td>
                                            <td>{{ $order->user_name ?? 'Guest Customer' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $order->user_email ?? $order->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Amount:</strong></td>
                                            <td><strong class="text-success">${{ number_format($order->total_price, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Order Date:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y H:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Current Status:</strong></td>
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
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Update Status Form -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Update Status</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="form-group">
                                            <label for="status" class="form-label">
                                                <strong>New Order Status</strong>
                                            </label>
                                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="">Select Status</option>
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                    Processing
                                                </option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                    Completed
                                                </option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="notes" class="form-label">
                                                Notes (Optional)
                                            </label>
                                            <textarea name="notes" id="notes" rows="4" 
                                                      class="form-control @error('notes') is-invalid @enderror"
                                                      placeholder="Add any notes about this status update..."></textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                These notes are for internal use only and won't be visible to customers.
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="notify_customer" name="notify_customer" value="1">
                                                <label class="custom-control-label" for="notify_customer">
                                                    Send email notification to customer
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                Check this to automatically send an email notification about the status change.
                                            </small>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Update Status
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Description Cards -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Status Descriptions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="media mb-3">
                                                <span class="badge badge-warning mr-3 mt-1">Pending</span>
                                                <div class="media-body">
                                                    <h6>Pending</h6>
                                                    <p class="mb-0 text-muted">Order has been placed but not yet processed.</p>
                                                </div>
                                            </div>
                                            
                                            <div class="media mb-3">
                                                <span class="badge badge-info mr-3 mt-1">Processing</span>
                                                <div class="media-body">
                                                    <h6>Processing</h6>
                                                    <p class="mb-0 text-muted">Order is being prepared and processed.</p>
                                                </div>
                                            </div>

                                            <div class="media mb-3">
                                                <span class="badge badge-success mr-3 mt-1">Completed</span>
                                                <div class="media-body">
                                                    <h6>Completed</h6>
                                                    <p class="mb-0 text-muted">Order has been completed and delivered to the customer.</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">

                                            <div class="media mb-3">
                                                <span class="badge badge-danger mr-3 mt-1">Cancelled</span>
                                                <div class="media-body">
                                                    <h6>Cancelled</h6>
                                                    <p class="mb-0 text-muted">Order has been cancelled and will not be processed.</p>
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
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-check notify customer checkbox for certain status changes
    $('#status').change(function() {
        const status = $(this).val();
        if (status === 'completed') {
            $('#notify_customer').prop('checked', true);
        }
    });

    // Confirmation for cancelled status
    $('form').submit(function(e) {
        const status = $('#status').val();
        if (status === 'cancelled') {
            if (!confirm('Are you sure you want to cancel this order? This action may affect inventory and customer expectations.')) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
@endpush
