<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SellerProductController extends Controller
{
    public function index()
    {
        if (auth()->user()->sellerProfile->verification_status !== 'approved') {
            abort(403);
        }        

        $sellerProfile = auth()->user()->sellerProfile;

        $products = Product::where('seller_profile_id', $sellerProfile->id)->get();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        if (auth()->user()->sellerProfile->verification_status !== 'approved') {
            abort(403);
        }

        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->sellerProfile->verification_status !== 'approved') {
            abort(403);
        }


        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category' => 'required',
            'condition' => 'required',
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
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

        $product = Product::create([
            'seller_profile_id' => auth()->user()->sellerProfile->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category' => $request->category,
            'condition' => $request->condition,
            'is_active' => false,
        ]);

        // Save images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');

                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        $discountEndsAt = null;

        if ($request->filled('discount_percentage') && $request->filled('discount_hours')) {
            $discountEndsAt = now()->addHours((int) $request->discount_hours);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,

            'discount_percentage' => $request->discount_percentage,
            'discount_ends_at' => $discountEndsAt,
            'free_shipping' => $request->has('free_shipping'),
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

        $discountEndsAt = null;
        $hours = (int) $request->discount_hours;

        if ($request->filled('discount_percentage') && $request->filled('discount_hours')) {
            $discountEndsAt = now()->addHours($hours);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,

            'discount_percentage' => $request->discount_percentage,
            'discount_ends_at' => $discountEndsAt,
            'free_shipping' => $request->has('free_shipping'),
        ]);

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