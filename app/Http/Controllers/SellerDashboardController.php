<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItem;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->sellerProfile;

        // Seller products
        $products = Product::where('seller_profile_id', $seller->id)->pluck('id');

        // Get ALL order items belonging to seller products
        $orderItems = OrderItem::whereIn('product_id', $products)
            ->with('order')
            ->get();

        // Orders (unique)
        $orders = $orderItems->pluck('order')->unique('id');

        // Completed order items (for revenue)
        $completedItems = $orderItems->filter(function ($item) {
            return $item->order->status === 'completed';
        });

        // ========================
        // STATS
        // ========================
        $totalOrders = $orders->count();
        $totalRevenue = $completedItems->sum(function ($item) {
            return $item->subtotal;
        });
        $totalProducts = $products->count();

        // ========================
        // REVIEWS (FIXED)
        // ========================
        $orderItemIds = $orderItems->pluck('id');

        $reviews = Review::whereIn('order_item_id', $orderItemIds)->get();

        $averageRating = round($reviews->avg('rating'), 1) ?? 0;
        $totalReviews = $reviews->count();
        $ratingDistribution = $reviews
            ->groupBy('rating')
            ->map(function ($group) {
                return $group->count();
            });
        $isTopRated = ($averageRating >= 4.5 && $totalReviews >= 10);

        // ========================
        // RECENT DATA
        // ========================
        $recentOrders = $orders->sortByDesc('created_at')->take(5);
        $recentReviews = $reviews->sortByDesc('created_at')->take(5);

        // ========================
        // CHARTS
        // ========================
        $revenueData = $completedItems
            ->groupBy(function ($item) {
                return $item->order->created_at->format('Y-m-d');
            })
            ->map(function ($items, $date) {
                return [
                    'date' => $date,
                    'total' => $items->sum('subtotal')
                ];
            })
            ->values();

        $orderData = $orders
            ->groupBy(function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->map(function ($orders, $date) {
                return [
                    'date' => $date,
                    'total' => $orders->count()
                ];
            })
            ->values();

        // ========================
        // TOP PRODUCTS
        // ========================
        $topProducts = OrderItem::whereIn('product_id', $products)
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->with('product')
            ->take(5)
            ->get();

        // ========================
        // LOW STOCK
        // ========================
        $lowStockProducts = Product::where('seller_profile_id', $seller->id)
            ->where('stock_quantity', '<', 5)
            ->get();

        // ========================
        // COMMISSION
        // ========================
        $commissionRate = 0.05;
        $platformEarnings = $totalRevenue * $commissionRate;
        $sellerEarnings = $totalRevenue - $platformEarnings;

        return view('seller.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
            'recentOrders' => $recentOrders,
            'recentReviews' => $recentReviews,
            'revenueData' => $revenueData,
            'orderData' => $orderData,
            'topProducts' => $topProducts,
            'lowStockProducts' => $lowStockProducts,
            'platformEarnings' => $platformEarnings,
            'sellerEarnings' => $sellerEarnings,
            'isTopRated' => $isTopRated,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }
}