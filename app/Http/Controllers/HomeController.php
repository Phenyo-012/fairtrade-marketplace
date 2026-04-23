<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // ========================
        // FEATURED PRODUCTS (LIVE QUERY)
        // ========================
        $featuredProducts = Product::where('is_approved', true)
            ->where('is_active', true)
            ->where('is_archived', false)
            ->with('images')
            ->latest()
            ->take(8)
            ->get();

        // ------------------------
        // SELLER SALES
        // ------------------------
        $sellerSales = OrderItem::select(
                'products.seller_profile_id',
                DB::raw('SUM(order_items.quantity) as total_sales')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('products.seller_profile_id');

        // ------------------------
        // SELLER RATINGS
        // ------------------------
        $sellerRatings = Review::select(
                DB::raw('AVG(rating) as avg_rating'),
                DB::raw('COUNT(*) as total_reviews'),
                'products.seller_profile_id'
            )
            ->join('order_items', 'reviews.order_item_id', '=', 'order_items.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('products.seller_profile_id');

        // ------------------------
        // FINAL LEADERBOARD QUERY
        // ------------------------
        $topStores = SellerProfile::select(
                'seller_profiles.*',
                DB::raw('COALESCE(sales.total_sales, 0) as total_sales'),
                DB::raw('COALESCE(ratings.avg_rating, 0) as avg_rating'),
                DB::raw('COALESCE(ratings.total_reviews, 0) as total_reviews'),
                DB::raw('
                    (COALESCE(sales.total_sales,0) * 0.6) +
                    (COALESCE(ratings.avg_rating,0) * 20) +
                    (COALESCE(ratings.total_reviews,0) * 0.4)
                    as score
                ')
            )
            ->where('seller_profiles.verification_status', 'approved')
            ->leftJoinSub($sellerSales, 'sales', function ($join) {
                $join->on('seller_profiles.id', '=', 'sales.seller_profile_id');
            })
            ->leftJoinSub($sellerRatings, 'ratings', function ($join) {
                $join->on('seller_profiles.id', '=', 'ratings.seller_profile_id');
            })
            ->orderByDesc('score')
            ->take(5)
            ->get();

        return view('home', compact('featuredProducts', 'topStores'));
    }
}