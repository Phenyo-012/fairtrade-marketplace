<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CompleteOrdersAfterDelivery extends Command
{
    protected $signature = 'orders:auto-complete';
    protected $description = 'Auto complete orders 24h after delivery';

    public function handle()
    {
        $orders = Order::where('status', 'delivered')
            ->whereNull('disputed_at') 
            ->whereNotNull('delivered_at')
            ->where('delivered_at', '<=', now()->subHours(24))
            ->get();

        foreach ($orders as $order) {
            $order->update([
                'status' => 'completed'
            ]);
        }

        $this->info('Orders auto-completed successfully.');
    }
}