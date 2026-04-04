<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Dispute;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    // SHOW FORM
    public function create(Order $order)
    {
        // SECURITY: only buyer can open dispute
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        // prevent duplicate disputes
        if ($order->dispute) {
            return redirect()->route('orders.my')
                ->with('error', 'Dispute already exists for this order.');
        }

        return view('disputes.create', compact('order'));
    }

    // STORE DISPUTE
    public function store(Request $request, Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        Dispute::create([
            'order_id' => $order->id,
            'opened_by' => auth()->id(),
            'reason' => $request->reason,
            'status' => 'open'
        ]);

        // 🔴 IMPORTANT: mark order as disputed
        $order->update([
            'status' => 'disputed'
        ]);

        return redirect()->route('orders.my')
            ->with('success', 'Dispute submitted successfully.');
    }

    // SHOW DISPUTE DETAILS
    public function show(Dispute $dispute)
    {
        // SECURITY: only buyer can view their dispute
        if ($dispute->order->buyer_id !== auth()->id()) {
            abort(403);
        }

        $dispute->load('order', 'resolvedBy');

        return view('disputes.show', compact('dispute'));
    }
}