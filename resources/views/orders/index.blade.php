@extends('layouts.public')

@section('title', 'My Orders | E-Commerce POC')

@section('content')
<h2 class="mb-4">My Orders</h2>

@if($orders->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
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
                                <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td>
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
                                </td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">You haven't placed any orders yet.</div>
@endif
@endsection
