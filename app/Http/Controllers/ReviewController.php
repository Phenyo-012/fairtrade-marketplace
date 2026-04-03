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

        $item = \App\Models\OrderItem::with('order')->findOrFail($orderItemId);

        //  ownership check
        if ($item->order->buyer_id !== auth()->id()) {
            abort(403);
        }

        //  NEW RULE
        if ($item->order->status !== 'delivered') {
            return back()->with('error', 'You can only review after delivery.');
        }

        // prevent duplicates
        if ($item->reviews()->exists()) {
            return back()->with('error', 'You already reviewed this product.');
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
        }

        \App\Models\Review::create([
            'order_id' => $item->order_id,
            'order_item_id' => $item->id,
            'buyer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $path ?? null
        ]);

        return back()->with('success', 'Review submitted.');
    }
}
