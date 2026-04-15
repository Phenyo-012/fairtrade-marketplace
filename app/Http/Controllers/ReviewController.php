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

        $orderItem = \App\Models\OrderItem::with('order')->findOrFail($orderItemId);

        //  ownership check
        if ($orderItem->order->buyer_id !== auth()->id()) {
            abort(403);
        }

        //  NEW RULE
        if (!$orderItem->order->canBeReviewed()) {
            return back()->with('error', 'You can only review after delivery.');
        }

        // prevent duplicates
        if ($orderItem->reviews()->exists()) {
            return back()->with('error', 'You already reviewed this product.');
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
        }

        \App\Models\Review::create([
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'buyer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $path ?? null,
            'status' => 'pending'
        ]);

        Cache::forget('top_stores');

        return back()->with('success', 'Review submitted.');
    }
}
