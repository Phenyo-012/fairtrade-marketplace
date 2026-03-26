<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    // LIST ORDERS
    public function index()
    {
        $sellerId = auth()->user()->sellerProfile->id;

        $orders = Order::whereHas('items.product', function ($q) use ($sellerId) {
                $q->where('seller_profile_id', $sellerId);
            })
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orders'));
    }

    // SHOW SINGLE ORDER
    public function show(Order $order)
    {
        $sellerId = auth()->user()->sellerProfile->id;

        // Filter ONLY seller's items
        $items = $order->items()
            ->whereHas('product', function ($q) use ($sellerId) {
                $q->where('seller_profile_id', $sellerId);
            })
            ->with('product')
            ->get();

        // If seller has no items in this order → block access
        if ($items->isEmpty()) {
            abort(403);
        }

        return view('seller.orders.show', compact('order', 'items'));
    }

    // UPDATE STATUS
    public function updateStatus(Request $request, Order $order)
    {
        $sellerId = auth()->user()->sellerProfile->id;

        // Ensure seller owns at least one item in this order
        $ownsOrder = $order->items()
            ->whereHas('product', function ($q) use ($sellerId) {
                $q->where('seller_profile_id', $sellerId);
            })
            ->exists();

        if (!$ownsOrder) {
            abort(403);
        }

        // LOCK FINAL STATES
        $lockedStatuses = ['delivered', 'completed', 'disputed', 'cancelled'];

        if (in_array($order->status, $lockedStatuses)) {
            return back()->with('error', 'This order can no longer be updated.');
        }

        // Validate allowed transitions
        $request->validate([
            'status' => 'required|in:awaiting_shipment,shipped'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated.');
    }
}