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
            $item->product->discounted_price * $item->quantity
        );

        return view('checkout.index', compact('items', 'total'));
    }

    public function preparePayment(Request $request)
    {
        $data = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:card,eft,ozow,cod',
        ]);

        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $total = $items->sum(fn ($item) =>
            $item->product->discounted_price * $item->quantity
        );

        if ($data['payment_method'] === 'cod' && $total > 2000) {
            return back()->withErrors([
                'payment_method' => 'Cash on Delivery is only available for orders up to R2,000.'
            ])->withInput();
        }

        session()->put('checkout_data', $data);

        return redirect()->route('checkout.payment');
    }

    public function showPayment()
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('checkout.index')
                ->with('error', 'Please complete checkout details first.');
        }

        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $total = $items->sum(fn ($item) =>
            $item->product->discounted_price * $item->quantity
        );

        return view('checkout.payment', [
            'paymentMethod' => $checkoutData['payment_method'],
            'total' => $total,
            'checkoutData' => $checkoutData,
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('checkout.index')
                ->with('error', 'Please complete checkout details first.');
        }

        $request->merge($checkoutData);

        return $this->store($request);
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
            'payment_method' => 'required|in:card,eft,ozow,cod',
        ]);

        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        $total = $items->sum(fn ($item) =>
            $item->product->discounted_price * $item->quantity
        );

        if ($request->payment_method === 'cod' && $total > 2000) {
            return redirect()->route('checkout.index')
                ->with('error', 'Cash on Delivery is only available for orders up to R2,000.');
        }

        DB::beginTransaction();

        try {

            // GROUP BY SELLER
            $grouped = $items->groupBy(fn ($item) =>
                $item->product->seller_profile_id
            );

            $orders = [];

            foreach ($grouped as $sellerId => $sellerItems) {

                $orderTotal = 0;

                foreach ($sellerItems as $item) {
                    $orderTotal += $item->product->discounted_price * $item->quantity;
                }

                // CREATE ORDER
                $order = Order::create([
                    'buyer_id' => auth()->id(),
                    'seller_profile_id' => $sellerId,
                    'total_amount' => $orderTotal,
                    'status' => 'pending',
                    'delivery_code' => strtoupper(Str::random(8)),
                    'seller_deadline' => now()->addDays(5),

                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'cod' ? 'pending_on_delivery' : 'paid',
                    'payment_reference' => strtoupper('PAY-' . Str::random(10)),

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

                    $unitPrice = $product->discounted_price;
                    $subtotal = $unitPrice * $item->quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $item->quantity,
                        'unit_price' => $unitPrice,
                        'original_price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);

                    $product->decrement('stock_quantity', $item->quantity);
                }

                $orders[] = $order;
            }

            // CLEAR CART
            CartItem::where('user_id', auth()->id())->delete();

            session()->forget('checkout_data');

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