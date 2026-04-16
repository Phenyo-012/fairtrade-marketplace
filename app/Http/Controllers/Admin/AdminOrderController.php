<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Dispute;
use App\Models\SellerProfile;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Order::with('orderItems.product');

        // ========================
        // FILTER: STATUS
        // ========================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ========================
        // FILTER: READY FOR COMPLETION (24H RULE)
        // ========================
        if ($request->filled('ready')) {
            $query->where('status', 'delivered')
                ->whereNotNull('delivered_at')
                ->where('delivered_at', '<=', now()->subHours(24));
        }

        // ========================
        // SEARCH: ORDER ID
        // ========================
        if ($request->filled('search')) {
            $query->where('id', $request->search);
        }

        // ========================
        // FILTER: DATE RANGE (optional but useful)
        // ========================
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product.images');

        return view('admin.orders.show', compact('order'));
    }

    public function complete(Order $order)
    {
        if (!$order->canBeCompletedByAdmin()) {
            return back()->with('error', 'Order cannot be completed yet (24h rule not met).');
        }

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Order marked as completed.');
    }
}
