<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load('orderItems.product');
        return view('orders.show', compact('order'));
    }
}
