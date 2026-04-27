<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // ========================
    // GENERIC ORDERS LIST
    // ========================
    public function index()
    {
        $orders = auth()->user()
            ->ordersPlaced()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // ========================
    // BUYER ORDERS
    // ========================
    public function myOrders(Request $request)
    {
        $query = Order::where('buyer_id', auth()->id())
            ->with('orderItems.product.images');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('id', $request->search);
        }

        $orders = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.my-orders', compact('orders'));
    }

    // ========================
    // SHOW ORDER
    // ========================
    public function show(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        $order->load([
            'orderItems.product.images',
            'orderItems.product.sellerProfile.user',
            'dispute',
            'review'
        ]);

        return view('orders.show', compact('order'));
    }

    // ========================
    // CHECKOUT (FROM CART)
    // ========================
    public function store(Request $request)
    {
        $user = auth()->user();

        // ========================
        // VALIDATION (IMPORTANT)
        // ========================
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|in:' . implode(',', config('provinces')),
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
        ]);

        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        if ($cartItems->contains(fn($i) => !$i->product)) {
            throw new \Exception("Cart contains invalid product data");
        }

        DB::beginTransaction();

        try {

            $total = 0;

            foreach ($cartItems as $item) {
                if (!$item->product->is_active || !$item->product->is_approved) {
                    throw new \Exception("Invalid product in cart.");
                }

                if (!$item->product->is_active || !$item->product->is_approved) {
                    throw new \Exception("Invalid product in cart.");
                }

                if ($item->product->stock_quantity < $item->quantity) {
                    throw new \Exception("Not enough stock for {$item->product->name}");
                }

                $total += $item->unit_price * $item->quantity;
            }

            $deliveryCode = strtoupper(Str::random(8));

            // ========================
            // CREATE ORDER
            // ========================
            $order = Order::create([
                'buyer_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_code' => $deliveryCode,
                'seller_deadline' => now()->addDays(5),

                // SHIPPING
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_province' => $request->shipping_province,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_country' => $request->shipping_country,
            ]);

            if (!$order) {
                throw new \Exception("Order could not be created.");
            }

            // ========================
            // CREATE ORDER ITEMS
            // ========================
            foreach ($cartItems as $item) {

                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->unit_price * $item->quantity,
                ]);

                // reduce stock
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // ========================
            // CLEAR CART
            // ========================
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {

            DB::rollBack();

            report($e);

            return back()->with('error', 'Failed to place order. Please try again.' . $e->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->can_buyer_cancel) {
            return back()->with('error', 'This order can no longer be cancelled.');
        }

        $order->update([
            'status' => 'cancelled',
        ]);

        // restore stock
        foreach ($order->orderItems()->with('product')->get() as $item) {
            if ($item->product) {
                $item->product->increment('stock_quantity', $item->quantity);
            }
        }

        return back()->with('success', 'Order cancelled successfully.');
    }
}