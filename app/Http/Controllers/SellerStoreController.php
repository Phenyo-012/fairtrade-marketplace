<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerStoreController extends Controller
{
    public function edit()
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        return view('seller.store.edit', compact('seller'));
    }

    public function update(Request $request)
    {
        $seller = auth()->user()->sellerProfile;

        if (!$seller) {
            abort(403);
        }

        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->storePublicly('logos', 's3');
        }

        $seller->update($data);

        return back()->with('success', 'Store updated');
    }
}