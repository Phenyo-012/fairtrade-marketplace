<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function create(Order $order)
    {
        return view('reviews.create', compact('order'));
    }

    public function store(Request $request, $orderItemId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $item = \App\Models\OrderItem::with('order', 'product')->findOrFail($orderItemId);

        // SECURITY: ensure buyer owns this order
        if ($item->order->buyer_id !== auth()->id()) {
            abort(403);
        }

        // prevent duplicate reviews
        if ($item->reviews()->exists()) {
            return back()->with('error', 'You already reviewed this product.');
        }

        \App\Models\Review::create([
            'order_id' => $item->order_id,
            'order_item_id' => $item->id,
            'buyer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Review submitted.');
    }
}
