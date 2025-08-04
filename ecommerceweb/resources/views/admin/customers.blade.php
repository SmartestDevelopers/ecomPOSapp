@extends('layouts.admin')

@section('title', 'Customer Management')
@section('page-title', 'Customers')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">Customer Management</h2>
        <p class="text-muted">Manage all customer accounts and their orders</p>
    </div>
    <div class="col-md-4">
        <form method="GET" class="d-flex">
            <input type="text" class="form-control" name="search" 
                   placeholder="Search customers..." 
                   value="{{ request('search') }}">
            <button class="btn btn-outline-primary ms-2" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Customers ({{ $customers->total() }})</h5>
    </div>
    <div class="card-body">
        @if($customers->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5>No customers found</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No customers found matching "{{ request('search') }}".
                    @else
                        No customers have registered yet.
                    @endif
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <strong>{{ $customer->name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ date('M d, Y', strtotime($customer->created_at)) }}</td>
                            <td>
                                @if($customer->orders_count > 0)
                                    <a href="{{ route('admin.customers.orders', $customer->id) }}" class="badge bg-primary text-decoration-none">
                                        {{ $customer->orders_count }} orders
                                    </a>
                                @else
                                    <span class="badge bg-secondary">No orders</span>
                                @endif
                            </td>
                            <td>
                                @if($customer->total_spent > 0)
                                    <strong>${{ number_format($customer->total_spent, 2) }}</strong>
                                @else
                                    <span class="text-muted">$0.00</span>
                                @endif
                            </td>
                            <td>
                                @if($customer->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Unverified</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($customer->orders_count > 0)
                                        <a href="{{ route('admin.customers.orders', $customer->id) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View Orders">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    @endif
                                    
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown" title="More Actions">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><h6 class="dropdown-header">Account Actions</h6></li>
                                        <li>
                                            <form action="{{ route('admin.users.updateRole', $customer->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="role" value="admin">
                                                <button type="submit" class="dropdown-item" onclick="return confirm('Make this customer an admin?')">
                                                    <i class="fas fa-user-shield me-2"></i>Make Admin
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $customers->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Customer Statistics -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h5>{{ $customers->total() }}</h5>
                <p class="text-muted mb-0">Total Customers</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h5>{{ $customers->where('email_verified_at', '!=', null)->count() }}</h5>
                <p class="text-muted mb-0">Verified Customers</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-2x text-warning mb-2"></i>
                <h5>{{ $customers->where('orders_count', '>', 0)->count() }}</h5>
                <p class="text-muted mb-0">Active Buyers</p>
            </div>
        </div>
    </div>
</div>
@endsection
