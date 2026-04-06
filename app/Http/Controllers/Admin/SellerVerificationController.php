<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerProfile;
use App\Models\User;

class SellerVerificationController extends Controller
{

    public function index()
    {
        $sellers = SellerProfile::where('verification_status', 'pending')->get();

        return view('admin.sellers.index', compact('sellers'));
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
