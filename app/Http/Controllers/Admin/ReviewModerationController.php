<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewModerationController extends Controller
{
    // PENDING ONLY (main page)
    public function index()
    {
        $reviews = Review::with('orderItem.product', 'buyer')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    // ARCHIVE (approved + rejected)
    public function archive()
    {
        $reviews = Review::with('orderItem.product', 'buyer')
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.archive', compact('reviews'));
    }

    // SHOW SINGLE REVIEW
    public function show(Review $review)
    {
        $review->load('orderItem.product', 'buyer');

        return view('admin.reviews.show', compact('review'));
    }

    // APPROVE
    public function approve(Review $review)
    {
        if ($review->status !== 'pending') {
            return back()->with('error', 'Already processed.');
        }

        $review->update(['status' => 'approved']);

        return redirect()->route('admin.reviews')
            ->with('success', 'Review approved');
    }

    // REJECT
    public function reject(Review $review)
    {
        if ($review->status !== 'pending') {
            return back()->with('error', 'Already processed.');
        }

        $review->update(['status' => 'rejected']);

        return redirect()->route('admin.reviews')
            ->with('success', 'Review rejected');
    }
}