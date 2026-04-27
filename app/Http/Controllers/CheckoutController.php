<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Cart is empty.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'subtotal'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Cart is empty.');
        }

        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $order = \App\Models\Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_amount' => $subtotal,
                'shipping_address' => [
                    'address' => $request->address,
                    'city' => $request->city,
                    'zip' => $request->zip,
                ]
            ]);

            foreach ($cart as $id => $item) {
                $product = \App\Models\Product::lockForUpdate()->findOrFail($id);

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);

                $product->decrement('stock_quantity', $item['quantity']);
            }

            \Illuminate\Support\Facades\DB::commit();
            session()->forget('cart');

            return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        return view('checkout.success');
    }
}
