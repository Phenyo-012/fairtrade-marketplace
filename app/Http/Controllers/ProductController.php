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

    //create a function to store the new product in the MySQL database
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

    public function index()
    {
        $sellerProfile = auth()->user()->sellerProfile;

        $products = $sellerProfile->products;

        return view('products.index', compact('products'));
    }
}
