<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;

class StoreController extends Controller
{
    public function show(SellerProfile $seller)
    {
        if ($seller->verification_status !== 'approved') {
            return redirect()->route('marketplace.index')
                ->with('error', 'Store Not Available.');
        }

        // Products
        $products = Product::where('seller_profile_id', $seller->id)
            ->where('is_approved', true)
            ->where('is_active', true)
            ->where('is_archived', false)
            ->with('images')
            ->latest()
            ->paginate(12);

        // GET SELLER PRODUCTS
        $productIds = Product::where('seller_profile_id', $seller->id)->pluck('id');

        // GET ORDER ITEMS
        $orderItemIds = OrderItem::whereIn('product_id', $productIds)
            ->pluck('id');

        // GET REVIEWS (NO LIMIT)
        $reviews = Review::whereIn('order_item_id', $orderItemIds)->get();

        // STATS (IDENTICAL TO DASHBOARD)
        $averageRating = round($reviews->avg('rating'), 1) ?? 0;
        $totalReviews = $reviews->count();

        // separate paginated reviews for display
        $displayReviews = Review::whereIn('order_item_id', $orderItemIds)
            ->with('orderItem.product')
            ->latest()
            ->paginate(10);

        // Shipping performance
        $totalShipped = Order::whereHas('Orderitems.product', function ($q) use ($seller) {
                $q->where('seller_profile_id', $seller->id);
            })
            ->whereNotNull('shipped_at')
            ->count();

        $lateShipments = Order::whereHas('Orderitems.product', function ($q) use ($seller) {
                $q->where('seller_profile_id', $seller->id);
            })
            ->where('is_late', true)
            ->count();

        $onTimeRate = $totalShipped > 0
            ? round((($totalShipped - $lateShipments) / $totalShipped) * 100)
            : 100;

        return view('store.show', compact(
            'seller',
            'products',
            'displayReviews',
            'averageRating',
            'totalReviews',
            'onTimeRate'
        ));
    }

    public function reviews(\App\Models\SellerProfile $seller)
    {
        $reviews = \App\Models\Review::whereHas('orderItem.product', function ($q) use ($seller) {
                $q->where('seller_profile_id', $seller->id);
            })
            ->with('orderItem.product')
            ->latest()
            ->paginate(10);

        return view('store.reviews', compact('seller', 'reviews'));
    }
}