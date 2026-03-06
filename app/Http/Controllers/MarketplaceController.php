<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = Product::where('is_approved', true)
            ->where('is_active', true)
            ->get();

        return view('marketplace.index', compact('products'));
    }

    public function show(Product $product)
    {
        if (!$product->is_approved || !$product->is_active) {
            abort(404);
        }

        return view('marketplace.show', compact('product'));
    }
}