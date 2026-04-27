@extends('layouts.public')

@section('title', 'Home | E-Commerce POC')

@section('content')
<div class="hero text-center rounded mb-5">
    <div class="container">
        <h1 class="display-4 font-weight-bold">Welcome to Our Store</h1>
        <p class="lead">Discover the best products at unbeatable prices.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg mt-3">Shop Now</a>
    </div>
</div>

<h2 class="mb-4 text-center">Featured Products</h2>
<div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach($products as $product)
    <div class="col">
        <div class="card h-100 product-card shadow-sm">
            @if($product->image_path)
                <img src="{{ Storage::url($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Placeholder">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-muted">{{ Str::limit($product->description, 50) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fs-5 fw-bold">${{ number_format($product->price, 2) }}</span>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm">View Details</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
