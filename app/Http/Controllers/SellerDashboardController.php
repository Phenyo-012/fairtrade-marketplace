<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->sellerProfile;

        // Seller product IDs
        $products = Product::where('seller_profile_id', $seller->id)->pluck('id');

        // ALL orders (for count)
        $allOrders = Order::whereIn('product_id', $products)->get();

        // ONLY completed orders (for revenue)
        $completedOrders = Order::whereIn('product_id', $products)
            ->where('status', 'completed')
            ->get();

        $totalOrders = $allOrders->count();
        $totalRevenue = $completedOrders->sum('total_amount');
        $totalProducts = $products->count();

        // Reviews (based on completed orders)
        $orderIds = $completedOrders->pluck('id');

        $reviews = Review::whereIn('order_id', $orderIds)->get();
        $averageRating = $reviews->avg('rating') ?? 0;

        // Recent data
        $recentOrders = $allOrders->sortByDesc('created_at')->take(5);
        $recentReviews = $reviews->sortByDesc('created_at')->take(5);

        // Charts (ONLY completed orders)
        $revenueData = Order::whereIn('product_id', $products)
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $orderData = Order::whereIn('product_id', $products)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top products (completed sales only)
        $topProducts = Order::whereIn('product_id', $products)
            ->where('status', '!=', 'cancelled')
            ->select('product_id', DB::raw('COUNT(*) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->with('product')
            ->take(5)
            ->get();

        // Low stock
        $lowStockProducts = Product::where('seller_profile_id', $seller->id)
            ->where('stock_quantity', '<', 5)
            ->get();

        // Commission
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