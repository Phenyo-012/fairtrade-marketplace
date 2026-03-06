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
}