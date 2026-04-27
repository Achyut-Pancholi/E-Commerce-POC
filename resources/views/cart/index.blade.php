@extends('layouts.public')

@section('title', 'Shopping Cart | E-Commerce POC')

@section('content')
<h1 class="mb-4">Shopping Cart</h1>

@if(count($cart) > 0)
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item['image_path'])
                                                    <img src="{{ Storage::url($item['image_path']) }}" alt="{{ $item['name'] }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3">
                                                @else
                                                    <img src="https://via.placeholder.com/50" alt="Placeholder" class="rounded me-3">
                                                @endif
                                                <a href="{{ route('products.show', $item['slug']) }}" class="text-decoration-none text-dark">{{ $item['name'] }}</a>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item['price'], 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                                                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fas fa-sync-alt"></i></button>
                                            </form>
                                        </td>
                                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong>${{ number_format($subtotal, 2) }}</strong>
                    </div>
                    
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 btn-lg">Proceed to Checkout</a>
                    @else
                        <div class="alert alert-warning mb-3">You need to login to checkout.</div>
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info text-center py-5 shadow-sm">
        <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
        <h3>Your cart is empty</h3>
        <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
@endif
@endsection
