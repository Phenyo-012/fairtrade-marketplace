<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    

    //create a function to return the view for creating a new product
    public function create()
    {
        return view('products.create');
    }

    //create a function to store the new product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category' => 'required|string',
            'condition' => 'required'
        ]);

        $sellerProfile = auth()->user()->sellerProfile;

        Product::create([
            'seller_profile_id' => $sellerProfile->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category' => $request->category,
            'condition' => $request->condition
        ]);

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    // LIST SELLER'S PRODUCTS
    public function index()
    {
        $sellerProfile = auth()->user()->sellerProfile;

        $products = $sellerProfile->products;

        return view('products.index', compact('products'));
    }

    // ARCHIVE PRODUCT
    public function archive(Product $product)
    {
        // CHECK IF THE PRODUCT BELONGS TO THE AUTHENTICATED SELLER
        if ($product->seller_profile_id !== auth()->user()->sellerProfile->id) {
            abort(403);
        }

        // ARCHIVE PRODUCT BY SETTING is_archived TO TRUE AND is_active TO FALSE
        $product->update([
            'is_archived' => true,
            'is_active' => false
        ]);

        return back()->with('success', 'Product archived.');
    }

    // UNARCHIVE PRODUCT
    public function unarchive(Product $product)
    {
       if ($product->seller_profile_id !== auth()->user()->sellerProfile->id) {
            abort(403);
        }

        $product->update([
            'is_archived' => false,
            'is_active' => true
        ]);

        return back()->with('success', 'Product restored.');
    }
}
