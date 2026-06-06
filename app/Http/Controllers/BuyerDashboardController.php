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

        // FILTER COMPLETED ORDERS
        $completedOrders = $orders->where('status', 'completed');

        // FILTER CANCELLED ORDERS
        $cancelledOrders = $orders->where('status', 'cancelled');

        // CALCULATE METRICS
        $totalOrders = $orders->count();

        // CALCULATE TOTAL SPENT ON COMPLETED ORDERS
        $totalSpent = $completedOrders->sum('total_amount');

        // CALCULATE ACTIVE DELIVERIES (SHIPPED BUT NOT YET DELIVERED)
        $activeDeliveries = $orders->where('status', 'shipped')->count();

        // CALCULATE OPEN DISPUTES
        $openDisputes = Dispute::whereHas('order', function ($q) use ($buyerId) {
                $q->where('buyer_id', $buyerId);
            })
            ->where('status', 'open')
            ->count();


        // CALCULATE REVIEWS SUBMITTED
        $reviewsSubmitted = Review::where('buyer_id', $buyerId)->count();

        $wishlistCount = Wishlist::where('user_id', $buyerId)->count();

        // GET RECENT ORDERS (LIMIT TO 5)
        $recentOrders = $orders->take(5);

        // GET RECENTLY ORDERED ITEMS (LIMIT TO 6)
        $recentItems = OrderItem::whereHas('order', function ($q) use ($buyerId) {
                $q->where('buyer_id', $buyerId);
            })
            ->with(['product.images', 'order'])
            ->latest()
            ->take(6)
            ->get();

        // CALCULATE ORDER STATUS COUNTS FOR DASHBOARD 
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