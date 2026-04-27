@extends('layouts.public')

@section('title', 'Products | E-Commerce POC')

@section('content')
<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Filter Products</h5>
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Product name...">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('products.index') }}" class="btn btn-link w-100 mt-2">Clear Filters</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="col-md-9">
        <h2 class="mb-4">Our Products</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($products as $product)
                <div class="col">
                    <div class="card h-100 product-card shadow-sm">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Placeholder">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ $product->category->name }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fs-5 fw-bold">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No products found matching your criteria.</div>
                </div>
            @endforelse
        </div>
        
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
