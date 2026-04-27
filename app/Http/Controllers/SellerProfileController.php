<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerProfile;
use App\Models\Role;

class SellerProfileController extends Controller
{
    // ========================
    // SETUP (INITIAL ENTRY)
    // ========================

    public function create()
    {
        if (auth()->user()->sellerProfile) {
            return redirect()->route('seller.onboarding');
        }

        return view('seller.setup');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->sellerProfile) {
            return redirect()->route('seller.onboarding');
        }

        $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048'
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $sellerProfile = SellerProfile::create([
            'user_id' => $user->id,
            'store_name' => $request->store_name,
            'about' => $request->about,
            'logo' => $logoPath,


            'verification_status' => 'not_submitted',
            'onboarding_step' => 1,
            'kyc_submitted' => false,
        ]);

        // Assign seller role
        $user->roles()->syncWithoutDetaching([
            Role::where('name', 'seller')->first()->id
        ]);

        // REDIRECT TO ONBOARDING
        return redirect()->route('seller.onboarding')
            ->with('success', 'Store created! Complete onboarding to start selling.');
    }

    // ========================
    // STORE EDIT
    // ========================

    public function edit()
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            return redirect()->route('seller.setup');
        }

        return view('seller.edit-store', compact('seller'));
    }

    public function update(Request $request)
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $seller->logo = $request->file('logo')->store('logos', 'public');
        }

        $seller->update([
            'store_name' => $request->store_name,
            'about' => $request->about,
            'pickup_address' => $request->pickup_address,
            'pickup_city' => $request->pickup_city,
            'pickup_province' => $request->pickup_province,
            'pickup_postal_code' => $request->pickup_postal_code,
            'pickup_country' => $request->pickup_country,
        ]);

        return back()->with('success', 'Store updated successfully.');
    }

    // ========================
    // ONBOARDING MAIN PAGE
    // ========================

    public function onboarding()
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            return redirect()->route('seller.setup');
        }

        return view('seller.onboarding', compact('seller'));
    }

    // ========================
    // STEP 1: STORE DETAILS
    // ========================

    public function storeStep(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'required|string|max:1000',
        ]);

        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        $seller->update([
            'store_name' => $request->store_name,
            'about' => $request->about,
            'onboarding_step' => 2
        ]);

        return redirect()->route('seller.onboarding')
            ->with('success', 'Store details saved.');
    }

    // ========================
    // STEP 2: KYC
    // ========================

    public function kycStep(Request $request)
    {
        $request->validate([
            'id_document' => 'required|image|max:2048',
            'selfie_document' => 'required|image|max:2048',
        ]);

        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        $seller->update([
            'id_document' => $request->file('id_document')->store('kyc', 'public'),
            'selfie_document' => $request->file('selfie_document')->store('kyc', 'public'),
            'kyc_submitted' => true,
            'verification_status' => 'pending',
            'onboarding_step' => 3
        ]);

        return redirect()->route('seller.pending')
            ->with('success', 'Verification submitted. Awaiting approval.');
    }

    // ========================
    // LEGACY KYC PAGE (OPTIONAL)
    // ========================

    public function showKyc()
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            return redirect()->route('seller.setup');
        }

        return view('seller.kyc');
    }

    public function submitKyc(Request $request)
    {
        return $this->kycStep($request);
    }
}