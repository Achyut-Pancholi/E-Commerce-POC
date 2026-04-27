@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Orders</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
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
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">View / Update</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
