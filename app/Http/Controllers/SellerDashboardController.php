<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->sellerProfile;

        $products = Product::where('seller_profile_id', $seller->id)->pluck('id');

        $orders = Order::whereIn('product_id', $products)
            ->where('status', 'completed')
            ->get();

        $totalRevenue = $orders->sum('total_amount');

        $totalOrders = $orders->count();

        $totalProducts = Product::where('seller_profile_id', $seller->id)->count();

        $averageRating = Review::whereIn('order_id', $products)->avg('rating') ?? 0;

        $recentOrders = Order::whereIn('product_id', $products)
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::whereIn('order_id', $products)
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'averageRating',
            'recentOrders',
            'recentReviews'
        ));
    }
}