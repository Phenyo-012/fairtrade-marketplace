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

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        Review::create([
            'order_id' => $order->id,
            'buyer_id' => auth()->id(),
            'seller_id' => $order->seller_profile_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('orders.my')
            ->with('success','Review submitted.');
    }
}
