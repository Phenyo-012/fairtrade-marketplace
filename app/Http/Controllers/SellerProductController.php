<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'cropped_images' => 'required|array|min:1|max:5',
            'cropped_images.*' => 'required|string',
        ]);

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

        // SAVE CROPPED IMAGES ONLY
        foreach ($request->cropped_images as $base64Image) {

            $image = str_replace('data:image/jpeg;base64,', '', $base64Image);
            $image = str_replace(' ', '+', $image);

            $imageName = 'product_' . time() . '_' . uniqid() . '.jpg';

            Storage::disk('public')->put(
                'products/' . $imageName,
                base64_decode($image)
            );

            $product->images()->create([
                'image_path' => 'products/' . $imageName
            ]);
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
        // check ownership
        if ($product->seller_profile_id !== auth()->user()->sellerProfile->id) {
            abort(403);
        }

        // prevent deleting if product has orders
        if ($product->orderItems()->exists()) {
            return back()->with('error', 'This product has orders and cannot be deleted. You can archive it instead.');
        }

        $product->delete(); // soft delete

        return back()->with('success', 'Product archived successfully.');
    }
}