@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Dashboard Stats -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Welcome back, {{ auth()->user()->name }}!</h2>
            <small class="text-muted">{{ date('F j, Y') }}</small>
        </div>
    </div>
</div>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $stats['total_users'] }}</h4>
                                    <p class="card-text">Total Users</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $stats['total_products'] }}</h4>
                                    <p class="card-text">Total Products</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $stats['total_orders'] }}</h4>
                                    <p class="card-text">Total Orders</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-shopping-cart fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $stats['pending_orders'] }}</h4>
                                    <p class="card-text">Pending Orders</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus me-2"></i>Add Product
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block">
                                        <i class="fas fa-plus me-2"></i>Add Category
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning btn-block">
                                        <i class="fas fa-list me-2"></i>View Orders
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('admin.users') }}" class="btn btn-info btn-block">
                                        <i class="fas fa-users me-2"></i>Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders and Users -->
            <div class="row">
                <!-- Recent Orders -->
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Orders</h5>
                        </div>
                        <div class="card-body">
                            @if($recentOrders->isEmpty())
                                <p class="text-muted">No orders yet.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentOrders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->id }}</a>
                                                </td>
                                                <td>{{ $order->user_name }}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($order->status === 'pending') bg-warning
                                                        @elseif($order->status === 'shipped') bg-primary
                                                        @elseif($order->status === 'delivered') bg-success
                                                        @else bg-secondary
                                                        @endif">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>${{ number_format($order->total_price, 2) }}</td>
                                                <td>{{ date('M d, Y', strtotime($order->created_at)) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Recent Users -->
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Users</h5>
                        </div>
                        <div class="card-body">
                            @if($recentUsers->isEmpty())
                                <p class="text-muted">No users yet.</p>
                            @else
                                @foreach($recentUsers as $user)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong>{{ $user->name }}</strong><br>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <span class="badge 
                                        @if($user->role === 'admin') bg-danger
                                        @else bg-primary
                                        @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
@endsection
