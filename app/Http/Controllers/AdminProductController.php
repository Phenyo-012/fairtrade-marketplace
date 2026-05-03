<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['images', 'sellerProfile'])
            ->where(function ($query) {
                $query->where('is_approved', false)
                    ->orWhere('is_active', false);
            })
            ->where('is_archived', false)
            ->latest()
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function approve($id)
    {
        $product = Product::with('sellerProfile')->findOrFail($id);

        if (!$product->sellerProfile) {
            return back()->with('error', 'This product has no seller profile.');
        }

        if ($product->sellerProfile->verification_status !== 'approved') {
            return back()->with('error', 'Cannot approve product because the seller is not approved.');
        }

        $product->forceFill([
            'is_approved' => true,
            'is_active' => true,
            'is_archived' => false,
        ])->save();

        return back()->with('success', 'Product approved and activated.');
    }
}