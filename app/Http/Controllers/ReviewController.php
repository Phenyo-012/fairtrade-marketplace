<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function create(Order $order)
    {
        $order->load(['orderItems.reviews']);

        $itemsToReview = $order->orderItems->filter(function ($item) {
            return !$item->reviews->where('buyer_id', auth()->id())->count();
        });

        return view('reviews.create', compact('order', 'itemsToReview'));
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
        if ($orderItem->reviews()->where('buyer_id', auth()->id())->exists()) {
            return back()->with('error', 'You already reviewed this product.');
        }

        $path = null;

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

    public function bulkStore(Request $request)
    {
       

        $request->validate([
            'items' => 'required|array',
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.rating' => 'required|integer|min:1|max:5',
            'items.*.comment' => 'nullable|string',
            'items.*.image' => 'nullable|image|max:2048',
        ]);
          
        foreach ($request->items as $index => $item) {

            $orderItem = \App\Models\OrderItem::with('order')->findOrFail($item['order_item_id']);

            // ownership check
            if ($orderItem->order->buyer_id !== auth()->id()) {
                continue; // skip instead of aborting everything
            }

            // delivery rule
            $order = $orderItem->order;

            if (
                $order->status !== 'delivered' &&
                $order->status !== 'completed'
            ) {
                dump("SKIP {$orderItem->id} → order not delivered");
                continue;
            }

            // prevent duplicates
            if ($orderItem->reviews()->where('buyer_id', auth()->id())->exists()) {
                continue;
            }

            // handle image safely per index
            $path = null;
            if ($request->hasFile("items.$index.image")) {
                $path = $request->file("items.$index.image")->store('reviews', 'public');
            }

            Review::create([
                'order_id' => $orderItem->order_id,
                'order_item_id' => $orderItem->id,
                'buyer_id' => auth()->id(),
                'rating' => $item['rating'],
                'comment' => $item['comment'] ?? null,
                'image' => $path,
                'status' => 'pending'
            ]);
        }

        \Cache::forget('top_stores');

        return back()->with('success', 'Reviews submitted successfully.');
    }
}
