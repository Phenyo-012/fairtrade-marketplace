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

    public function preparePayment()
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('checkout.index')
                ->with('error', 'Please complete checkout first.');
        }

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

    private function shippingRates()
    {
        return [
            'small' => [
                'local' => 50,
                'national' => 100,
            ],
            'medium' => [
                'local' => 70,
                'national' => 130,
            ],
            'large' => [
                'local' => 100,
                'national' => 180,
            ],
        ];
    }

    private function getShippingZone($sellerProfile, $buyerProvince)
    {
        return strtolower($sellerProfile->pickup_province ?? '') === strtolower($buyerProvince)
            ? 'local'
            : 'national';
    }

    private function calculateShippingForItem($item, $buyerProvince)
    {
        $product = $item->product;

        if ($product->free_shipping) {
            return 0;
        }

        $size = $product->shipping_size ?? 'small';
        $sellerProfile = $product->sellerProfile;

        $zone = $this->getShippingZone($sellerProfile, $buyerProvince);

        return $this->shippingRates()[$size][$zone] ?? 0;
    }

    public function review(Request $request)
    {
        $data = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|in:' . implode(',', config('provinces')),
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:card,eft,ozow,cod',
        ]);

        $items = CartItem::where('user_id', auth()->id())
            ->with('product.sellerProfile', 'product.images')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $breakdown = $items->map(function ($item) use ($data) {
            $unitPrice = $item->product->discounted_price;
            $subtotal = $unitPrice * $item->quantity;
            $shippingFee = $this->calculateShippingForItem($item, $data['shipping_province']);

            return [
                'item' => $item,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $subtotal + $shippingFee,
            ];
        });

        $itemsTotal = $breakdown->sum('subtotal');
        $shippingTotal = $breakdown->sum('shipping_fee');
        $grandTotal = $itemsTotal + $shippingTotal;

        if ($data['payment_method'] === 'cod' && $grandTotal > 2000) {
            return back()->withErrors([
                'payment_method' => 'Cash on Delivery is only available for orders up to R2,000 including shipping.'
            ])->withInput();
        }

        session()->put('checkout_data', $data);
        session()->put('checkout_breakdown', $breakdown->map(fn ($row) => [
            'product_id' => $row['item']->product_id,
            'shipping_fee' => $row['shipping_fee'],
        ])->values()->toArray());

        return view('checkout.review', compact(
            'breakdown',
            'itemsTotal',
            'shippingTotal',
            'grandTotal',
            'data'
        ));
    }

    // PROCESS CHECKOUT
    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|in:' . implode(',', config('provinces')),
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:card,eft,ozow,cod',
        ]);

        $shippingBreakdown = collect(session('checkout_breakdown', []))
            ->keyBy('product_id');

        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        $cartItemsTotal = $items->sum(fn ($item) =>
            $item->product->discounted_price * $item->quantity
        );

        $cartShippingTotal = $items->sum(fn ($item) =>
            $shippingBreakdown[$item->product_id]['shipping_fee'] ?? 0
        );

        $cartGrandTotal = $cartItemsTotal + $cartShippingTotal;

        if ($request->payment_method === 'cod' && $cartGrandTotal > 2000) {
            return redirect()->route('checkout.index')
                ->with('error', 'Cash on Delivery is only available for orders up to R2,000 including shipping.');
        }

        DB::beginTransaction();

        try {

            // GROUP BY SELLER
            $grouped = $items->groupBy(fn ($item) =>
                $item->product->seller_profile_id
            );

            $orders = [];

            foreach ($grouped as $sellerId => $sellerItems) {

                $orderItemsTotal = 0;
                $orderShippingTotal = 0;

                foreach ($sellerItems as $item) {
                    $unitPrice = $item->product->discounted_price;
                    $orderItemsTotal += $unitPrice * $item->quantity;

                    $orderShippingTotal += $shippingBreakdown[$item->product_id]['shipping_fee'] ?? 0;
                }

                $orderTotal = $orderItemsTotal + $orderShippingTotal;

                $order = Order::create([
                    'buyer_id' => auth()->id(),
                    'seller_profile_id' => $sellerId,
                    'total_amount' => $orderTotal,
                    'shipping_fee' => $orderShippingTotal,
                    'status' => 'pending',
                    'delivery_code' => strtoupper(Str::random(8)),
                    'seller_deadline' => now()->addDays(5),
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'cod' ? 'pending_on_delivery' : 'paid',
                    'payment_reference' => strtoupper('PAY-' . Str::random(10)),
                    'shipping_name' => $request->shipping_name,
                    'shipping_phone' => $request->shipping_phone,
                    'shipping_address' => $request->shipping_address,
                    'shipping_province' => $request->shipping_province,
                    'shipping_city' => $request->shipping_city,
                    'shipping_province' => $request->shipping_province,
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

            session()->forget(['checkout_data', 'checkout_breakdown']);

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