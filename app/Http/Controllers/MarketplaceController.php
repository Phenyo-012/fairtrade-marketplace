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

        $reviewsQuery = \App\Models\Review::with([
            'orderItem.product',
            'votes'
        ])
        ->where('status', 'approved')
        ->whereHas('orderItem', function ($q) use ($product) {
            $q->where('product_id', $product->id);
        });

        // rating filter
        if (request()->filled('rating')) {
            $reviewsQuery->where('rating', '>=', request('rating'));
        }

        // sorting
        if (request()->filled('sort')) {

            if (request('sort') === 'highest') {
                $reviewsQuery->orderBy('rating', 'desc');
            }

            if (request('sort') === 'lowest') {
                $reviewsQuery->orderBy('rating', 'asc');
            }

            if (request('sort') === 'helpful') {
                $reviewsQuery->withCount(['votes as helpful_count' => function ($q) {
                    $q->where('is_helpful', true);
                }])->orderByDesc('helpful_count');
            }

        } else {
            $reviewsQuery->latest();
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

        $ratingCounts = \App\Models\Review::selectRaw('rating, COUNT(*) as count')
            ->whereHas('orderItem', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            })
            ->groupBy('rating')
            ->pluck('count', 'rating');

        $totalReviews = $ratingCounts->sum();

        $ratingPercentages = [];

        for ($i = 1; $i <= 5; $i++) {
            $count = $ratingCounts[$i] ?? 0;
            $ratingPercentages[$i] = $totalReviews > 0
                ? round(($count / $totalReviews) * 100)
                : 0;
        }

        return view('marketplace.show', compact('product', 'reviews', 'related' , 'ratingPercentages', 'totalReviews'));
    }
}