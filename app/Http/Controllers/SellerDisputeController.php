<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use Illuminate\Http\Request;

class SellerDisputeController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->sellerProfile;

        $disputes = Dispute::whereHas('order.orderItems.product', function ($q) use ($seller) {
            $q->where('seller_profile_id', $seller->id);
        })
        ->latest()
        ->get();

        return view('seller.disputes.index', compact('disputes'));
    }

    public function show(Dispute $dispute)
    {
        $seller = auth()->user()->sellerProfile;

        // SECURITY: only seller of product can access
        $allowed = $dispute->order->orderItems->contains(function ($item) use ($seller) {
            return $item->product->seller_profile_id === $seller->id;
        });

        if (!$allowed) {
            abort(403);
        }

        return view('seller.disputes.show', compact('dispute'));
    }

    public function respond(Request $request, Dispute $dispute)
    {
        $seller = auth()->user()->sellerProfile;

        $allowed = $dispute->order->orderItems->contains(function ($item) use ($seller) {
            return $item->product->seller_profile_id === $seller->id;
        });

        if (!$allowed) {
            abort(403);
        }

        if ($dispute->seller_response) {
            return back()->with('error', 'You already responded.');
        }

        $request->validate([
            'response' => 'required|string|max:2000'
        ]);

        $dispute->update([
            'seller_response' => $request->response,
            'seller_responded_at' => now()
        ]);

        return back()->with('success', 'Response submitted.');
    }
}