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

        // ========================
        // 💰 ESCROW + COMPLETED
        // ========================

        // Items NOT completed = escrow
        $escrowItems = $orderItems->filter(function ($item) {
            return !in_array($item->order->status, ['completed', 'cancelled', 'disputed']);
        });

        // Completed = earned
        $completedItems = $orderItems->filter(function ($item) {
            return $item->order->status === 'completed';
        });

        // 💰 ESCROW TOTAL
        $escrowBalance = $escrowItems->sum(function ($item) {
            return $item->subtotal;
        });

        // 💰 TOTAL EARNED (completed only)
        $totalRevenue = $completedItems->sum(function ($item) {
            return $item->subtotal;
        });

        // ========================
        // STATS
        // ========================
        $totalOrders = \App\Models\Order::where('seller_profile_id', $seller->id)
            ->where('status', 'completed')
            ->count();
        $totalProducts = Product::where('seller_profile_id', $seller->id)
            ->where('is_archived', false)
            ->count();

        // ========================
        // REVIEWS
        // ========================
        $orderItemIds = $orderItems->pluck('id');

        $reviews = Review::whereIn('order_item_id', $orderItemIds)->get();

        $averageRating = round($reviews->avg('rating'), 1) ?? 0;
        $totalReviews = $reviews->count();

        $ratingDistribution = $reviews
            ->groupBy('rating')
            ->map(fn ($group) => $group->count());

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
            ->groupBy(fn ($item) => $item->order->created_at->format('Y-m-d'))
            ->map(fn ($items, $date) => [
                'date' => $date,
                'total' => $items->sum('subtotal')
            ])
            ->values();

        $orderData = $orders
            ->groupBy(fn ($order) => $order->created_at->format('Y-m-d'))
            ->map(fn ($orders, $date) => [
                'date' => $date,
                'total' => $orders->count()
            ])
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
             ->where('is_archived', false)
            ->get();

        // ========================
        // COMMISSION
        // ========================
        $commissionRate = 0.05;

        $platformEarnings = $totalRevenue * $commissionRate;
        $sellerEarnings = $totalRevenue - $platformEarnings;

        // ========================
        // SHIPPING PERFORMANCE
        // ========================
        $totalShipped = Order::whereHas('orderItems.product', function ($q) use ($seller) {
                $q->where('seller_profile_id', $seller->id);
            })
            ->whereNotNull('shipped_at')
            ->count();

        $lateShipments = Order::whereHas('orderItems.product', function ($q) use ($seller) {
                $q->where('seller_profile_id', $seller->id);
            })
            ->whereNotNull('shipped_at')
            ->where('is_late', true)
            ->count();

        $onTimeShipments = $totalShipped - $lateShipments;

        $onTimeRate = $totalShipped > 0
            ? round(($onTimeShipments / $totalShipped) * 100)
            : 100;

        $pendingOrders = $orders->whereIn('status', ['pending', 'awaiting_shipment'])->count();

        $activeDiscounts = Product::where('seller_profile_id', $seller->id)
            ->whereNotNull('discount_percentage')
            ->where('discount_percentage', '>', 0)
            ->whereNotNull('discount_ends_at')
            ->where('discount_ends_at', '>', now())
            ->count();

        $conversionRate = $totalProducts > 0
            ? round(($totalOrders / $totalProducts) * 100, 1)
            : 0;

        return view('seller.dashboard', [
            'totalRevenue' => $totalRevenue,
            'escrowBalance' => $escrowBalance, // ⭐ NEW
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
            'onTimeRate' => $onTimeRate,
            'lateShipments' => $lateShipments,
            'totalShipped' => $totalShipped,
            'pendingOrders' => $pendingOrders,
            'activeDiscounts' => $activeDiscounts,
            'conversionRate' => $conversionRate,
        ]);
    }
}