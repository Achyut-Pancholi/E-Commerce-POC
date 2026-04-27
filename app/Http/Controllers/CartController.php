<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(\Illuminate\Http\Request $request, \App\Models\Product $product)
    {
        if (!$product->is_active || $product->stock_quantity < 1) {
            return back()->with('error', 'Product is not available.');
        }

        $quantity = $request->input('quantity', 1);
        if ($quantity > $product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds stock.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] + $quantity > $product->stock_quantity) {
                return back()->with('error', 'Requested quantity exceeds stock.');
            }
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image_path' => $product->image_path,
                'slug' => $product->slug,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Product $product)
    {
        $quantity = $request->input('quantity');
        if ($quantity < 1) {
            return $this->remove($product);
        }

        if ($quantity > $product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds stock.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(\App\Models\Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed from cart.');
    }
}
