@extends('layouts.admin')

@section('title', 'Customer Orders')
@section('page-title', 'Customer Orders')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Customer Orders for {{ $customer->name }}</h2>
    <a href="{{ route('admin.customers') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Customers
    </a>
</div>

@if(session('success'))
    div class="alert alert-success alert-dismissible fade show" role="alert"
        {{ session('success') }}
        button type="button" class="btn-close" data-bs-dismiss="alert"/button
    /div
@endif

div class="card"
    div class="card-header"
        h5 class="mb-0"Orders for {{ $customer->name }}/h5
    /div
    div class="card-body"
        @if($orders->isEmpty())
            div class="text-center py-5"
                i class="fas fa-box-open fa-3x text-muted mb-3"/i
                h5No orders found/h5
                p class="text-muted"This customer has not placed any orders yet./p
            /div
        @else
            div class="table-responsive"
                table class="table table-hover"
                    thead
                        tr
                            thOrder ID/th
                            thDate/th
                            thStatus/th
                            thTotal/th
                            thActions/th
                        /tr
                    /thead
                    tbody
                        @foreach($orders as $order)
                        tr
                            td
                                a href="{{ route('admin.orders.show', $order->id) }}"
                                    #{{ $order->id }}
                                /a
                            /td
                            td{{ date('M d, Y', strtotime($order->created_at)) }}/td
                            td
                                span class="badge 
                                    @if($order->status === 'pending') bg-warning
                                    @elseif($order->status === 'processing') bg-info
                                    @elseif($order->status === 'completed') bg-success
                                    @else bg-secondary
                                    @endif"
                                    {{ ucfirst($order->status) }}
                                /span
                            /td
                            td${{ number_format($order->total_price, 2) }}/td
                            td
                                a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="btn btn-sm btn-outline-primary"
                                    i class="fas fa-eye"/i View
                                /a
                            /td
                        /tr
                        @endforeach
                    /tbody
                /table
            /div

            div class="d-flex justify-content-center mt-4"
                {{ $orders->links() }}
            /div
        @endif
    /div
/div

@endsection
