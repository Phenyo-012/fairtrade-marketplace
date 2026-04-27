<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerCourierController extends Controller
{
    private function couriers()
    {
        return [
            'fastway' => [
                'name' => 'Fastway Couriers',
                'description' => 'Affordable local and national parcel delivery.',
                'services' => [
                    ['name' => 'Standard Delivery', 'days' => '2-4 business days', 'fee' => 85],
                    ['name' => 'Express Delivery', 'days' => '1-2 business days', 'fee' => 140],
                ],
            ],
            'aramex' => [
                'name' => 'Aramex',
                'description' => 'National courier service with tracking support.',
                'services' => [
                    ['name' => 'Door-to-Door', 'days' => '2-3 business days', 'fee' => 110],
                    ['name' => 'Priority Express', 'days' => '1 business day', 'fee' => 180],
                ],
            ],
            'The Courier Guy' => [
                'name' => 'The Courier Guy ',
                'description' => 'Door-to-door, locker-to-locker and locker-to-door parcel shipping.',
                'services' => [
                    ['name' => 'Door-to-Door', 'days' => '2-3 business days', 'fee' => 110],
                    ['name' => 'Locker Delivery', 'days' => '2-5 business days', 'fee' => 60],
                    ['name' => 'Locker to Door', 'days' => '2-4 business days', 'fee' => 95],
                ],
            ],
            'dsv' => [
                'name' => 'DSV',
                'description' => 'Business courier and logistics simulation.',
                'services' => [
                    ['name' => 'Economy Freight', 'days' => '3-5 business days', 'fee' => 130],
                    ['name' => 'Priority Freight', 'days' => '1-3 business days', 'fee' => 220],
                ],
            ],
        ];
    }

    private function authorizeSellerOrder(Order $order)
    {
        $sellerProfileId = auth()->user()->sellerProfile->id;

        if ((int) $order->seller_profile_id !== (int) $sellerProfileId) {
            abort(403);
        }
    }

    public function index(Order $order)
    {
        $this->authorizeSellerOrder($order);

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Cancelled orders cannot be shipped.');
        }

        $couriers = $this->couriers();

        return view('seller.orders.couriers.index', compact('order', 'couriers'));
    }

    public function show(Order $order, string $courier)
    {
        $this->authorizeSellerOrder($order);

        $couriers = $this->couriers();

        if (!array_key_exists($courier, $couriers)) {
            abort(404);
        }

        return view('seller.orders.couriers.show', [
            'order' => $order,
            'courierKey' => $courier,
            'courier' => $couriers[$courier],
        ]);
    }

    public function book(Request $request, Order $order, string $courier)
    {
        $this->authorizeSellerOrder($order);

        $couriers = $this->couriers();

        if (!array_key_exists($courier, $couriers)) {
            abort(404);
        }

        if (!$order->can_seller_ship) {
            return back()->with('error', 'You can only book courier shipping after the buyer cancellation window has expired.');
        }

        $request->validate([
            'service' => 'required|string',
            'parcel_weight' => 'required|numeric|min:0.1',
            'parcel_notes' => 'nullable|string|max:1000',
        ]);

        $selectedService = collect($couriers[$courier]['services'])
            ->firstWhere('name', $request->service);

        if (!$selectedService) {
            return back()->with('error', 'Invalid courier service selected.');
        }

        $trackingNumber = strtoupper(substr($courier, 0, 3)) . '-' . strtoupper(Str::random(10));

        $isLate = $order->seller_deadline && now()->gt($order->seller_deadline);

        $order->update([
            'courier_name' => $couriers[$courier]['name'],
            'courier_service' => $selectedService['name'],
            'courier_tracking_number' => $trackingNumber,
            'courier_fee' => $selectedService['fee'],
            'courier_booked_at' => now(),

            // existing shipping fields
            'status' => 'shipped',
            'shipped_at' => now(),
            'is_late' => $isLate,
        ]);

        return redirect()
            ->route('seller.orders.show', $order)
            ->with('success', 'Courier booked successfully. Tracking number: ' . $trackingNumber);
    }
}