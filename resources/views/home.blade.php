@extends('layouts.public')

@section('title', 'Home | KL ecommerce')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(236, 72, 153, 0.1));
        border-radius: 24px;
        padding: 80px 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 4rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.02);
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 60%);
        z-index: 0;
        animation: rotate 20s linear infinite;
    }
    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1rem;
        letter-spacing: -1px;
    }
    .hero-subtitle {
        font-size: 1.25rem;
        color: #475569;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .product-card {
        border: none;
        border-radius: 16px;
        background: #fff;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        height: 100%;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .product-img-wrapper {
        position: relative;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        overflow: hidden;
        background: #f1f5f9;
    }
    .product-img-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img-wrapper img {
        transform: scale(1.08);
    }
    .card-body {
        padding: 1.5rem;
    }
    .product-title {
        font-weight: 700;
        font-size: 1.2rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .product-desc {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    .product-price {
        font-weight: 800;
        font-size: 1.3rem;
        color: var(--primary);
    }
    .btn-view {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #334155;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-view:hover {
        background: var(--primary);
        color: #fff;
    }
    .section-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50%;
        height: 4px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        border-radius: 2px;
    }
</style>

<div class="hero-section text-center">
    <div class="hero-content">
        <h1 class="hero-title">Elevate Your Lifestyle</h1>
        <p class="hero-subtitle">Discover our curated collection of premium products designed to bring joy and innovation to your everyday life.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-lg" style="border-radius: 50px; font-size: 1.1rem;">
            Explore Collection <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<div class="d-flex justify-content-between align-items-end mb-4">
    <h2 class="section-title mb-0">Featured Arrivals</h2>
    <a href="{{ route('products.index') }}" class="text-primary text-decoration-none fw-bold">View All <i class="fas fa-chevron-right ms-1" style="font-size: 0.8em;"></i></a>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
    @foreach($products as $product)
    <div class="col">
        <div class="product-card">
            <div class="product-img-wrapper">
                @if($product->image_path)
                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('images/placeholder.png') }}" alt="Product Image">
                @endif
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="product-title">{{ $product->name }}</h5>
                <p class="product-desc flex-grow-1">{{ Str::limit($product->description, 60) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-view">Details</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
