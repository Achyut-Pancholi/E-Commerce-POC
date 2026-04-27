<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Product::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->paginate(12);
        $categories = \App\Models\Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(\App\Models\Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        return view('products.show', compact('product'));
    }
}
