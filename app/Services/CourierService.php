<?php

namespace App\Services;

class CourierService
{
    public function createShipment($sellerAddress, $buyerAddress, $order)
    {
        // Simulate courier API call
        return [
            'tracking_number' => strtoupper('TRK' . rand(100000, 999999)),
            'courier' => 'MockCourier',
            'status' => 'created',
            'pickup_address' => $sellerAddress,
            'delivery_address' => $buyerAddress,
        ];
    }
}