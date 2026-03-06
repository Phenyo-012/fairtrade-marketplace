<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    public function index()
    {
        $orders = auth()->user()
            ->ordersPlaced()
            ->with('product')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
    
    public function store(Request $request, Product $product)
    {
        $user = auth()->user();

        if (!$product->is_approved || !$product->is_active) {
            abort(404);
        }

        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            return back()->with('error', 'Invalid quantity.');
        }

        if ($product->stock_quantity < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $total = $product->price * $quantity;

        $deliveryCode = strtoupper(Str::random(8));

        $sellerDeadline = now()->addDays(5);

        $order = Order::create([
            'buyer_id' => $user->id,
            'seller_profile_id' => $product->seller_profile_id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_amount' => $total,
            'status' => 'pending',
            'delivery_code' => $deliveryCode,
            'seller_deadline' => $sellerDeadline
        ]);

        $product->decrement('stock_quantity', $quantity);

        return redirect('/orders/'.$order->id)
            ->with('success', 'Order placed successfully.');
    }
}