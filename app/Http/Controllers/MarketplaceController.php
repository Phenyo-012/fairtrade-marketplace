<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_approved', true)
                        ->where('is_active', true)
                        ->with(['images', 'reviews']);

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Condition filter
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $products = $query->latest()->paginate(12);

        return view('marketplace.index', compact('products'));
    }

    public function show(Product $product)
    {
        if (!$product->is_approved || !$product->is_active) {
            abort(404);
        }

        $reviewsQuery = \App\Models\Review::with('orderItem.product')
            ->whereHas('orderItem', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            });

        // ADD THIS BLOCK HERE (rating filter)
        if (request()->filled('rating')) {
            $reviewsQuery->where('rating', '>=', request('rating'));
        }

        $reviews = $reviewsQuery
            ->latest()
            ->paginate(5)
            ->withQueryString(); // keeps filter in pagination

        $related = Product::where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->where('is_approved', true)
                ->where('is_active', true)
                ->with('images')
                ->latest()
                ->take(4)
                ->get();

        return view('marketplace.show', compact('product', 'reviews', 'related'));
    }
}