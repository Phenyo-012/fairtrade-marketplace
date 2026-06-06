<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        // FETCH ALL PENDING OR INACTIVE PRODUCTS WITH RELATED IMAGES AND SELLER PROFILES
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
        // FETCH PRODUCT WITH SELLER PROFILE
        $product = Product::with('sellerProfile')->findOrFail($id);

        // CHECK IF SELLER PROFILE EXISTS AND IS APPROVED
        if (!$product->sellerProfile) {
            return back()->with('error', 'This product has no seller profile.');
        }

        // CHECK IF SELLER PROFILE IS APPROVED
        if ($product->sellerProfile->verification_status !== 'approved') {
            return back()->with('error', 'Cannot approve product because the seller is not approved.');
        }

        // APPROVE AND ACTIVATE PRODUCT
        $product->forceFill([ // FORCE FILL TO BYPASS MASS ASSIGNMENT PROTECTION
            'is_approved' => true,
            'is_active' => true,
            'is_archived' => false,
        ])->save();

        return back()->with('success', 'Product approved and activated.');
    }
}