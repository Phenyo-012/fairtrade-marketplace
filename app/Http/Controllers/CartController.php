<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;

class CartController extends Controller
{
    // VIEW CART
    public function index()
    {
        $items = CartItem::where('user_id', auth()->id())
            ->with('product.images')
            ->get();

        $total = $items->sum(function ($item) {
            return $item->product->discounted_price * $item->quantity;
        });

        return view('cart.index', compact('items', 'total'));
    }

    // ADD TO CART
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($request->quantity > $product->stock_quantity) {
            return back()->with('error', 'Not enough stock available');
        }

        $item = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $newQty = $item->quantity + $request->quantity;

            if ($newQty > $product->stock_quantity) {
                return back()->with('error', 'Exceeds available stock');
            }

            $item->update([
                'quantity' => $newQty
            ]);
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Added to cart');
    }

    // UPDATE QUANTITY
    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        if ($request->quantity > $item->product->stock_quantity) {
            return back()->with('error', 'Exceeds available stock');
        }

        $item->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Cart updated');
    }

    // REMOVE ITEM
    public function destroy(CartItem $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Item removed');
    }

    // CLEAR CART
    public function clear()
    {
        CartItem::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Cart cleared');
    }
}