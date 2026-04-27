<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::where('is_active', true)->take(8)->get();
        return view('home', compact('products'));
    }
}
