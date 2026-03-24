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

        // Seller product IDs
        $productIds = Product::where('seller_profile_id', $seller->id)->pluck('id');

        $orderItems = OrderItem::whereIn('product_id', $productIds)
            ->with(['order', 'product'])
            ->get();

        $totalOrders = $orderItems->pluck('order_id')->unique()->count();

        $totalRevenue = $orderItems
            ->filter(fn($item) => $item->order && $item->order->status === 'completed')
            ->sum('subtotal');

        $totalProducts = $productIds->count();

        $completedOrderIds = $orderItems
            ->filter(fn($item) => $item->order && $item->order->status === 'completed')
            ->pluck('order_id')
            ->unique();

        $reviews = Review::whereIn('order_id', $completedOrderIds)->get();

        $averageRating = $reviews->avg('rating') ?? 0;

        $recentOrders = Order::whereIn('id', $orderItems->pluck('order_id')->unique())
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = $reviews->sortByDesc('created_at')->take(5);

        $revenueData = OrderItem::whereIn('product_id', $productIds)
            ->whereHas('order', function ($q) {
                $q->where('status', 'completed');
            })
            ->selectRaw('DATE(created_at) as date, SUM(subtotal) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $orderData = Order::whereIn('id', $orderItems->pluck('order_id')->unique())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = OrderItem::whereIn('product_id', $productIds)
            ->whereHas('order', function ($q) {
                $q->where('status', '!=', 'cancelled');
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->with('product')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('seller_profile_id', $seller->id)
            ->where('stock_quantity', '<', 5)
            ->get();

        $commissionRate = 0.05;
        $platformEarnings = $totalRevenue * $commissionRate;
        $sellerEarnings = $totalRevenue - $platformEarnings;

        return view('seller.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'averageRating' => $averageRating,
            'recentOrders' => $recentOrders,
            'recentReviews' => $recentReviews,
            'revenueData' => $revenueData,
            'orderData' => $orderData,
            'topProducts' => $topProducts,
            'lowStockProducts' => $lowStockProducts,
            'platformEarnings' => $platformEarnings,
            'sellerEarnings' => $sellerEarnings,
        ]);
    }
}