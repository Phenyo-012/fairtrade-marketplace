<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Dispute;

class DisputeController extends Controller
{
    public function create(Order $order)
    {
        return view('disputes.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'required',
            'description' => 'required|min:10'
        ]);

        $dispute = Dispute::create([
            'order_id' => $order->id,
            'opened_by' => auth()->id(),
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'open'
        ]);

        // Update order status
        $order->status = 'disputed';
        $order->save();

        return redirect()->route('orders.my')
            ->with('success', 'Dispute opened successfully.');
    }
}