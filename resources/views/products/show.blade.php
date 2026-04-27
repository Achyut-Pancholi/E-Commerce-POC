@extends('layouts.public')

@section('title', $product->name . ' | E-Commerce POC')

@section('content')
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            @if($product->image_path)
                <img src="{{ Storage::url($product->image_path) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x400" class="img-fluid rounded" alt="Placeholder">
            @endif
        </div>
    </div>
    
    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
        <p class="text-muted lead">{{ $product->category->name }}</p>
        
        <h2 class="text-primary mb-4">${{ number_format($product->price, 2) }}</h2>
        
        <div class="mb-4">
            <h5>Description</h5>
            <p>{{ $product->description }}</p>
        </div>
        
        <div class="mb-4">
            <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                {{ $product->stock_quantity > 0 ? 'In Stock (' . $product->stock_quantity . ')' : 'Out of Stock' }}
            </span>
        </div>

        @if($product->stock_quantity > 0)
        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex align-items-center mb-4">
            @csrf
            <div class="me-3">
                <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock_quantity }}" style="width: 80px;">
            </div>
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-cart-plus me-2"></i> Add to Cart
            </button>
        </form>
        @else
            <button class="btn btn-secondary btn-lg px-5" disabled>Out of Stock</button>
        @endif
    </div>
</div>
@endsection
