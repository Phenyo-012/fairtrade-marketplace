<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerProfile;
use App\Models\Role;

class SellerProfileController extends Controller
{
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

        $sellerProfile = SellerProfile::create([
            'user_id' => $user->id,
            'store_name' => 'Untitled Store',
            'about' => null,
            'logo' => null,
            'verification_status' => 'not_submitted',
            'onboarding_step' => 1,
            'kyc_submitted' => false,
        ]);

        $sellerRole = Role::where('name', 'seller')->first();

        if ($sellerRole) {
            $user->roles()->syncWithoutDetaching([$sellerRole->id]);
        }

        return redirect()->route('seller.onboarding')
            ->with('success', 'Seller profile created. Complete onboarding to start selling.');
    }

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

        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|max:2048',
            'pickup_address' => 'nullable|string|max:255',
            'pickup_city' => 'nullable|string|max:100',
            'pickup_province' => 'nullable|string|in:' . implode(',', config('provinces')),
            'pickup_postal_code' => 'nullable|string|max:20',
            'pickup_country' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $seller->update($data);

        return back()->with('success', 'Store updated successfully.');
    }

    public function onboarding()
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            return redirect()->route('seller.setup');
        }

        return view('seller.onboarding', compact('seller'));
    }

    public function storeStep(Request $request)
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'required|string|max:1000',
            'logo' => 'required|image|max:2048',
            'pickup_address' => 'required|string|max:255',
            'pickup_city' => 'required|string|max:100',
            'pickup_province' => 'required|string|in:' . implode(',', config('provinces')),
            'pickup_postal_code' => 'required|string|max:20',
            'pickup_country' => 'required|string|max:100',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $data['onboarding_step'] = 2;

        $seller->update($data);

        return redirect()->route('seller.onboarding')
            ->with('success', 'Store details saved.');
    }

    public function kycStep(Request $request)
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        $request->validate([
            'id_document' => 'required|image|max:2048',
            'selfie_document' => 'required|image|max:2048',
        ]);

        $seller->update([
            'id_document' => $request->file('id_document')->store('kyc', 'public'),
            'selfie_document' => $request->file('selfie_document')->store('kyc', 'public'),
            'kyc_submitted' => true,
            'verification_status' => 'pending',
            'onboarding_step' => 3,
        ]);

        return redirect()->route('seller.pending')
            ->with('success', 'Verification submitted. Awaiting approval.');
    }

    public function showKyc()
    {
        return redirect()->route('seller.onboarding');
    }

    public function submitKyc(Request $request)
    {
        return $this->kycStep($request);
    }
}