<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CourierService;

class SellerOrderController extends Controller
{
    // LIST ORDERS
    public function index(Request $request)
    {
        $sellerId = auth()->user()->sellerProfile->id;

        $query = Order::whereHas('orderItems.product', function ($q) use ($sellerId) {
            $q->where('seller_profile_id', $sellerId);
        })->with(['orderItems.product']);

        // FILTER BY STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // SEARCH BY ORDER ID
        if ($request->filled('search')) {
            $query->where('id', $request->search);
        }

        // PAGINATION
        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('seller.orders.index', compact('orders'));
    }

    // SHOW SINGLE ORDER
    public function show(Order $order)
    {
        $sellerId = auth()->user()->sellerProfile->id;

        // Filter ONLY seller's items
        $orderItems = $order->orderItems()
            ->whereHas('product', function ($q) use ($sellerId) {
                $q->where('seller_profile_id', $sellerId);
            })
            ->with('product')
            ->get();

        // If seller has no items in this order → block access
        if ($orderItems->isEmpty()) {
            abort(403);
        }

        return view('seller.orders.show', compact('order', 'orderItems'));
    }

    // UPDATE STATUS
    public function updateStatus(Request $request, Order $order)
    {
        $sellerId = auth()->user()->sellerProfile->id;

        $ownsOrder = $order->orderItems()
            ->whereHas('product', function ($q) use ($sellerId) {
                $q->where('seller_profile_id', $sellerId);
            })
            ->exists();

        if (!$ownsOrder) {
            abort(403);
        }

        $lockedStatuses = ['delivered', 'completed', 'disputed', 'cancelled'];

        if (in_array($order->status, $lockedStatuses)) {
            return back()->with('error', 'This order can no longer be updated.');
        }

        $request->validate([
            'status' => 'required|in:awaiting_shipment,shipped'
        ]);

        $newStatus = $request->status;

        // Prevent shipping during buyer cancellation window
        if ($newStatus === 'shipped' && !$order->can_seller_ship) {
            return back()->with('error', 'You can only mark this order as shipped after the buyer cancellation window has expired.');
        }

        // ========================
        // WHEN SHIPPING
        // ========================
        if ($newStatus === 'shipped') {

            $isLate = false;

            if ($order->seller_deadline && now()->gt($order->seller_deadline)) {
                $isLate = true;
            }

            $order->update([
                'status' => 'shipped',
                'shipped_at' => now(),   
                'is_late' => $isLate     
            ]);

            } 
            
            else {
                $order->update([
                    'status' => $newStatus
                ]);
            }
 
        return back()->with('success', 'Order status updated successfully.');
    }

    public function ship(Order $order, CourierService $courierService)
    {
        $sellerAddress = auth()->user()->sellerProfile->address;
        $buyerAddress = $order->shipping_address;

        $shipment = $courierService->createShipment(
            $sellerAddress,
            $buyerAddress,
            $order
        );

        $order->update([
            'status' => 'shipped',
            'tracking_number' => $shipment['tracking_number']
        ]);

        return back()->with('success', 'Order shipped with tracking: ' . $shipment['tracking_number']);
    }
    
}