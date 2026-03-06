<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_approved', false)->get();

        return view('admin.products.index', compact('products'));
    }

    public function approve($id)
    {
        $product = Product::findOrFail($id);

        $product->is_approved = true;
        $product->save();

        return redirect()->back()->with('success', 'Product approved.');
    }
}