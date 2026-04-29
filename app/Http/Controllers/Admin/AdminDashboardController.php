<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Dispute;
use App\Models\SellerProfile;
use App\Models\Review;
use Illuminate\Support\Facades\DB;


class AdminDashboardController extends Controller
{
    public function index()
    {

        // Late shipments %
        $totalOrders = Order::where('status', 'completed')->count();

        $lateOrders = Order::where('is_late', true)->count();

        $latePercentage = $totalOrders > 0
            ? ($lateOrders / $totalOrders) * 100
            : 0;

        // Avg delivery time (hours)
        $avgDeliveryTime = Order::whereNotNull('delivered_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, delivered_at)) as avg_time'))
            ->value('avg_time');

        $badSellers = DB::table('disputes')
            ->join('orders', 'disputes.order_id', '=', 'orders.id')
            ->join('seller_profiles', 'orders.seller_profile_id', '=', 'seller_profiles.id')
            ->select(
                'seller_profiles.store_name',
                DB::raw('COUNT(*) as disputes')
            )
            ->groupBy('seller_profiles.store_name')
            ->having('disputes', '>', 3)
            ->get();

        $badBuyers = DB::table('disputes')
            ->join('orders', 'disputes.order_id', '=', 'orders.id')
            ->join('users', 'orders.buyer_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                DB::raw('COUNT(*) as disputes')
            )
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->having('disputes', '>', 3)
            ->get();

        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $platformRevenue = $totalRevenue * 0.05;
        
        // DAILY REVENUE (last 180 days)
        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $sellerEarnings = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('seller_profiles', 'products.seller_profile_id', '=', 'seller_profiles.id')
            ->select(
                'seller_profiles.id',
                'seller_profiles.store_name',
                DB::raw('SUM(order_items.subtotal) as earnings')
            )
            ->groupBy('seller_profiles.id', 'seller_profiles.store_name')
            ->orderByDesc('earnings')
            ->take(10) // Get top 10 sellers 
            ->get();

        $readyForCompletion = Order::where('status', 'delivered')
            ->whereNotNull('delivered_at')
            ->get()
            ->filter(fn($order) => $order->canBeCompletedByAdmin());

        return view('admin.dashboard', [
            'totalUsers' => User::where('is_archived', false)->count(),
            'totalOrders' => $totalOrders,
            'totalProducts' => Product::count(),
            'pendingProducts' => Product::where('is_approved', false)->count(),
            'pendingSellers' => SellerProfile::where('verification_status', 'pending')->count(),
            'openDisputes' => Dispute::where('status', 'open')->count(),
            'totalRevenue' => $totalRevenue,
            'platformRevenue' => $platformRevenue,
            'totalDisputes' => Dispute::count(),
            'totalSellers' => SellerProfile::count(),
            'totalReviews' => Review::count(),
            'dailyRevenue' => $dailyRevenue,
            'sellerEarnings' => $sellerEarnings,
            'latePercentage' => $latePercentage,
            'avgDeliveryTime' => $avgDeliveryTime,
            'badSellers' => $badSellers,
            'badBuyers' => $badBuyers,
        ]);
    }
}