<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CourierController extends Controller
{
    public function showForm()
    {
        return view('courier.confirm-delivery');
    }

    public function confirmDelivery(Request $request)
    {
        $request->validate([
            'delivery_code' => 'required|string'
        ]);

        $order = Order::where('delivery_code', $request->delivery_code)
            ->where('status', 'shipped')
            ->first();

        if (!$order) {
            return back()->with('error', 'Invalid code or order not ready for delivery.');
        }

        /* Step 1: mark delivered */
        $order->status = 'delivered';
        $order->delivered_at = now();

        /* Step 2: release escrow */
        $order->payment_status = 'released';

        /* Step 3: complete order */
        $order->status = 'completed';

        $order->save();

        return back()->with('success', 'Delivery confirmed. Escrow released and order completed.');
    }
}