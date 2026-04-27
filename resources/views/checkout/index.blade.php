@extends('layouts.public')

@section('title', 'Checkout | E-Commerce POC')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2 class="mb-4">Checkout</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <h5 class="mb-3">Shipping Information</h5>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip" class="form-label">ZIP Code</label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{ old('zip') }}" required>
                            @error('zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 mt-3">Place Order</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <h4 class="mb-4">Your Order</h4>
        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    @foreach($cart as $item)
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $item['name'] }}</h6>
                                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                            </div>
                            <span class="text-muted">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-between border-top pt-3">
                    <strong>Total (USD)</strong>
                    <strong>${{ number_format($subtotal, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
