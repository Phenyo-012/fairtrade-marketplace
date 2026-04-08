<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerProfile;
use App\Models\User;

class SellerVerificationController extends Controller
{

   public function index(Request $request)
    {
        $status = $request->get('status'); // pending | rejected | approved

        $query = SellerProfile::with('user');

        if ($status) {
            $query->where('verification_status', $status);
        } else {
            // default: show pending + rejected
            $query->whereIn('verification_status', ['pending', 'rejected']);
        }

        $sellers = $query->latest()->get();

        return view('admin.sellers.index', compact('sellers', 'status'));
    }

    public function approve(SellerProfile $seller)
    {
        $seller->update([
            'verification_status' => 'approved',
            'verification_notes' => 'Approved by admin'
        ]);

        return back()->with('success', 'Seller approved');
    }

    public function reject(Request $request, SellerProfile $seller)
    {
        $seller->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->notes
        ]);

        return back()->with('success', 'Seller rejected');
    }
}
