<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerProfile;

class SellerProfileController extends Controller
{
    // SHOW SETUP FORM
    public function create()
    {
        if (auth()->user()->sellerProfile) {
            return redirect()->route('seller.store.edit');
        }

        return view('seller.setup');
    }

    // STORE NEW SELLER PROFILE
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->sellerProfile) {
            return redirect()->route('seller.store.edit');
        }

        $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image'
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $sellerProfile = SellerProfile::create([
            'user_id' => $user->id,
            'store_name' => $request->store_name,
            'about' => $request->about,
            'logo' => $logoPath
        ]);

        // ASSIGN SELLER ROLE
        $user->roles()->syncWithoutDetaching([
            \App\Models\Role::where('name', 'seller')->first()->id
        ]);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Seller account created successfully!');
    }

    // EDIT STORE
    public function edit()
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            return redirect()->route('seller.setup');
        }

        return view('seller.edit-store', compact('seller'));
    }

    // UPDATE STORE
    public function update(Request $request)
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image'
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $seller->logo = $path;
        }

        $seller->update([
            'store_name' => $request->store_name,
            'about' => $request->about
        ]);

        return back()->with('success', 'Store updated successfully.');
    }
}