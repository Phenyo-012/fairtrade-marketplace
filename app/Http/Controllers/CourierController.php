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

        $order->status = 'delivered';
        $order->delivered_at = now();
        $order->save();

        return back()->with('success', 'Delivery confirmed. Package may be handed to buyer.');
    }
}