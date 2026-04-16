<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // SHOW CHECKOUT PAGE
    public function index()
    {
        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        $total = $items->sum(fn ($item) =>
            $item->product->price * $item->quantity
        );

        return view('checkout.index', compact('items', 'total'));
    }

    // PROCESS CHECKOUT
    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
        ]);

        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        DB::beginTransaction();

        try {

            // GROUP ITEMS BY SELLER
            $grouped = $items->groupBy(fn ($item) =>
                $item->product->seller_profile_id
            );

            $orders = [];

            foreach ($grouped as $sellerId => $sellerItems) {

                $total = 0;

                foreach ($sellerItems as $item) {
                    $total += $item->product->price * $item->quantity;
                }

                // create order per seller
                $order = Order::create([
                    'buyer_id' => auth()->id(),
                    'seller_profile_id' => $sellerId,
                    'total_amount' => $total,
                    'status' => 'pending',
                    'delivery_code' => strtoupper(Str::random(8)),
                    'seller_deadline' => now()->addDays(5),

                    // shipping
                    'shipping_name' => $request->shipping_name,
                    'shipping_phone' => $request->shipping_phone,
                    'shipping_address' => $request->shipping_address,
                    'shipping_city' => $request->shipping_city,
                    'shipping_postal_code' => $request->shipping_postal_code,
                    'shipping_country' => $request->shipping_country,
                ]);

                foreach ($sellerItems as $item) {

                    $product = $item->product;

                    if (!$product->is_active || !$product->is_approved) {
                        throw new \Exception("Product unavailable: {$product->name}");
                    }

                    if ($product->stock_quantity < $item->quantity) {
                        throw new \Exception("Not enough stock for {$product->name}");
                    }

                    $subtotal = $product->price * $item->quantity;
                    $total += $subtotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                        'unit_price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);

                    $product->decrement('stock_quantity', $item->quantity);
                }

                // update total AFTER items
                $order->update([
                    'total_amount' => $total
                ]);

                $orders[] = $order;
            }

            // clear cart
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', [
                'orders' => implode(',', collect($orders)->pluck('id')->toArray())
            ])->with('success', 'Orders placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    // SUCCESS PAGE
    public function success($orders)
    {
        $ids = explode(',', $orders);

        $orders = Order::whereIn('id', $ids)
            ->where('buyer_id', auth()->id())
            ->with('orderItems.product.images')
            ->get();

        if ($orders->isEmpty()) {
            abort(404);
        }

        return view('checkout.success', compact('orders'));
    }
}