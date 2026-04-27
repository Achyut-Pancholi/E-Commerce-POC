@extends('layouts.public')

@section('title', 'Order Success | E-Commerce POC')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 text-center">
        <div class="card shadow-sm border-0 py-5">
            <div class="card-body">
                <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                <h1 class="display-6 fw-bold">Order Placed Successfully!</h1>
                <p class="lead text-muted">Thank you for your purchase. Your order is being processed.</p>
                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary me-2">View My Orders</a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
