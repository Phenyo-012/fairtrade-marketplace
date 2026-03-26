<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CourierController extends Controller
{
    // SHOW FORM (PUBLIC)
    public function showForm()
    {
        return view('courier.confirm-delivery');
    }

    // CONFIRM DELIVERY (PUBLIC)
    public function confirm(Request $request)
    {
        $request->validate([
            'delivery_code' => 'required|string'
        ]);

        $order = Order::where('delivery_code', $request->delivery_code)->first();

        // INVALID CODE
        if (!$order) {
            return back()->with('error', 'Invalid delivery code.');
        }

        // ALREADY DELIVERED
        if ($order->status === 'delivered') {
            return back()->with('error', 'This order is already confirmed.');
        }

        // NOT READY FOR DELIVERY
        if ($order->status !== 'shipped' && $order->status !== 'out_for_delivery') {
            return back()->with('error', 'Order is not ready for delivery confirmation.');
        }

        // CONFIRM DELIVERY
        $order->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);

        return back()->with('success', 'Delivery successfully confirmed.');
    }
}