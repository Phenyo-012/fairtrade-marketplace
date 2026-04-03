<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewVote;

class ReviewVoteController extends Controller
{
    public function vote(Request $request, $reviewId)
    {
        $request->validate([
            'is_helpful' => 'required|boolean'
        ]);

        ReviewVote::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'review_id' => $reviewId
            ],
            [
                'is_helpful' => $request->is_helpful
            ]
        );

        return back()->with('success', 'Thanks for your feedback!');
    }
}