@extends('layouts.public')

@section('title', 'Order details | E-Commerce POC')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back to Orders</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none text-dark">
                                            {{ $item->product->name }}
                                        </a>
                                    </td>
                                    <td>${{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <th>${{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Shipping:</th>
                                <th>$0.00</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end fs-5">Total:</th>
                                <th class="fs-5">${{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Status:</strong> 
                    @php
                        $badges = [
                            'pending' => 'bg-warning text-dark',
                            'confirmed' => 'bg-info text-dark',
                            'shipped' => 'bg-primary',
                            'delivered' => 'bg-success',
                            'cancelled' => 'bg-danger'
                        ];
                    @endphp
                    <span class="badge {{ $badges[$order->status] ?? 'bg-secondary' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <hr>
                <h6>Shipping Address</h6>
                <address class="mb-0">
                    {{ $order->shipping_address['address'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }}<br>
                    {{ $order->shipping_address['zip'] ?? '' }}
                </address>
            </div>
        </div>
    </div>
</div>
@endsection
