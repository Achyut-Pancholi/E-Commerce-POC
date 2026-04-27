@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <h2 class="mb-0">{{ \App\Models\Order::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Revenue</h5>
                <h2 class="mb-0">${{ number_format(\App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount'), 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Products</h5>
                <h2 class="mb-0">{{ \App\Models\Product::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3 shadow-sm text-dark">
            <div class="card-body">
                <h5 class="card-title">Customers</h5>
                <h2 class="mb-0">{{ \App\Models\User::where('role', 'customer')->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Orders</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
