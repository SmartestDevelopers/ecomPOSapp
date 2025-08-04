@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">My Orders</h1>
    @if($orders->isEmpty())
        <div class="alert alert-info">You have no orders yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->status }}</td>
                        <td>${{ number_format($order->total_price, 2) }}</td>
                        <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
