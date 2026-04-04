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

        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);

        return view('checkout.index', compact('items', 'total'));
    }

    // PROCESS CHECKOUT
    public function store(Request $request)
    {
        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();

        try {
            // Calculate total
            $totalAmount = $items->sum(fn($item) => $item->product->price * $item->quantity);

            // Calculate Seller Deadline
            $sellerDeadline = now()->addDays(5);

            // Create one order
            $order = Order::create([
                'buyer_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_code' => strtoupper(Str::random(8)),
                'seller_deadline' => $sellerDeadline
            ]);

            // Create order items & reduce stock
            foreach ($items as $item) {
                $product = $item->product;

                if (!$product->is_approved || !$product->is_active) {
                    throw new \Exception("Product unavailable: {$product->name}");
                }

                if ($product->stock_quantity < $item->quantity) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $item->quantity,
                ]);

                $product->decrement('stock_quantity', $item->quantity);
            }

            // Clear cart
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // SUCCESS PAGE
   public function success(Order $order)
    {
        // Make sure user owns order
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.product.images');

        return view('checkout.success', compact('order'));
    }
}