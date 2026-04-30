<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Dispute;
use Illuminate\Support\Facades\Auth;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $buyerId = Auth::id();

        $orders = Order::where('buyer_id', $buyerId)
            ->with(['orderItems.product.images', 'sellerProfile'])
            ->latest()
            ->get();

        $activeOrders = $orders->whereIn('status', [
            'pending',
            'awaiting_shipment',
            'shipped',
            'delivered',
        ]);

        $completedOrders = $orders->where('status', 'completed');

        $cancelledOrders = $orders->where('status', 'cancelled');

        $totalOrders = $orders->count();

        $totalSpent = $completedOrders->sum('total_amount');

        $activeDeliveries = $orders->where('status', 'shipped')->count();

        $openDisputes = Dispute::whereHas('order', function ($q) use ($buyerId) {
                $q->where('buyer_id', $buyerId);
            })
            ->where('status', 'open')
            ->count();

        $reviewsSubmitted = Review::where('buyer_id', $buyerId)->count();

        $wishlistCount = Wishlist::where('user_id', $buyerId)->count();

        $recentOrders = $orders->take(5);

        $recentItems = OrderItem::whereHas('order', function ($q) use ($buyerId) {
                $q->where('buyer_id', $buyerId);
            })
            ->with(['product.images', 'order'])
            ->latest()
            ->take(6)
            ->get();

        $statusCounts = [
            'pending' => $orders->where('status', 'pending')->count(),
            'awaiting_shipment' => $orders->where('status', 'awaiting_shipment')->count(),
            'shipped' => $orders->where('status', 'shipped')->count(),
            'delivered' => $orders->where('status', 'delivered')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $cancelledOrders->count(),
        ];

        return view('buyer.dashboard', compact(
            'orders',
            'activeOrders',
            'completedOrders',
            'totalOrders',
            'totalSpent',
            'activeDeliveries',
            'openDisputes',
            'reviewsSubmitted',
            'wishlistCount',
            'recentOrders',
            'recentItems',
            'statusCounts'
        ));
    }
}