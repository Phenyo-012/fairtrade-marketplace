<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReviewController extends Controller
{
    public function create(Order $order)
    {
        if ((int) $order->buyer_id !== (int) auth()->id()) {
            abort(403);
        }

        $order->load([
            'orderItems.product.images',
            'orderItems.reviews',
        ]);

        $itemsToReview = $order->orderItems->filter(function ($item) {
            return $item->canBeReviewed();
        });

        return view('reviews.create', compact('order', 'itemsToReview'));
    }

    public function store(Request $request, $orderItemId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $orderItem = OrderItem::with(['order', 'reviews'])->findOrFail($orderItemId);

        if (!$orderItem->canBeReviewed()) {
            return back()->with('error', 'You can only review this product after delivery and only once.');
        }

        Review::create([
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'buyer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending',
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
        ]);

        $created = 0;

        foreach ($request->items as $item) {
            $orderItem = OrderItem::with(['order', 'reviews'])->findOrFail($item['order_item_id']);

            if (!$orderItem->canBeReviewed()) {
                continue;
            }

            Review::create([
                'order_id' => $orderItem->order_id,
                'order_item_id' => $orderItem->id,
                'buyer_id' => auth()->id(),
                'rating' => $item['rating'],
                'comment' => $item['comment'] ?? null,
                'status' => 'pending',
            ]);

            $created++;
        }

        Cache::forget('top_stores');

        if ($created === 0) {
            return back()->with('error', 'No reviews were submitted. The order may not be reviewable or all items may already be reviewed.');
        }

        return back()->with('success', 'Reviews submitted successfully.');
    }
}