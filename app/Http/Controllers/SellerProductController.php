<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SellerProductController extends Controller
{
    public function index()
    {
        $sellerProfile = auth()->user()->sellerProfile;

        $products = Product::where('seller_profile_id', $sellerProfile->id)->get();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category' => 'required',
            'condition' => 'required',
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('storage/product_images/' . $filename);

            // Resize image
            Image::make($image)
                ->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path);

            $data['image'] = 'product_images/' . $filename;
        }

        Product::create([
            'seller_profile_id' => auth()->user()->sellerProfile->id,
            ...$data,
            'is_active' => false
        ]);
        return redirect()->route('seller.products.index')
            ->with('success','Product created.');
    }

    public function edit(Product $product)
    {
        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return redirect()->route('seller.products.index')
            ->with('success','Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success','Product deleted.');
    }
}