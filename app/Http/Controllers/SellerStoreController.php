<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerStoreController extends Controller
{
    public function edit()
    {
        $seller = auth()->user()->sellerProfile;
        return view('seller.store.edit', compact('seller'));
    }

    public function update(Request $request)
    {
        $seller = auth()->user()->sellerProfile;

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

        return back()->with('success', 'Store updated');
    }
}
