@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Orders Management</h3>
                </div>
                
                <div class="card-body">
                    <!-- Filters and Search -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('admin.orders.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search by order ID or customer..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('admin.orders.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="text-right">
                                <span class="text-muted">Total Orders: {{ $orders->total() }}</span>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>{{ $order->user_name ?? 'Guest' }}</td>
                                    <td>{{ $order->user_email ?? $order->email }}</td>
                                    <td>
                                        <strong>${{ number_format($order->total_price, 2) }}</strong>
                                    </td>
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
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                                               class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                               class="btn btn-sm btn-warning" title="Edit Status">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                            <p>No orders found.</p>
                                            @if(request('search') || request('status'))
                                                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                                                    Clear Filters
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Quick Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Order Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="pending">Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus(orderId, currentStatus) {
    $('#statusForm').attr('action', `/admin/orders/${orderId}`);
    $('#status').val(currentStatus);
    $('#statusModal').modal('show');
}
</script>
@endpush
