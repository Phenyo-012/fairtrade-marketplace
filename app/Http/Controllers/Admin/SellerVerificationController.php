<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerProfile;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class SellerVerificationController extends Controller
{

   public function index(Request $request)
    {
        $status = $request->get('status'); // pending | rejected | approved | archived

        $query = SellerProfile::with('user');

        if ($status) {
            $query->where('verification_status', $status);
        } else {
            // default: show pending + rejected
            $query->whereIn('verification_status', ['pending', 'rejected']);
        }

        $sellers = $query->latest()->get();

        return view('admin.sellers.index', compact('sellers', 'status'));
    }

    public function approve(SellerProfile $seller)
    {
        $seller->update([
            'verification_status' => 'approved',
            'verification_notes' => 'Approved by admin'
        ]);

        return back()->with('success', 'Seller approved');
    }

    public function reject(Request $request, SellerProfile $seller)
    {
        $seller->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->notes
        ]);

        return back()->with('success', 'Seller rejected');
    }

    public function show($id)
    {
        $seller = SellerProfile::with('user')->findOrFail($id);

        // Products
        $products = $seller->products()->latest()->get();

        // Orders (through products)
        $orders = OrderItem::whereHas('product', function ($q) use ($id) {
                $q->where('seller_profile_id', $id);
            })
            ->with('product', 'order')
            ->latest()
            ->paginate(20);

        // Earnings
        $earnings = OrderItem::whereHas('product', function ($q) use ($id) {
                $q->where('seller_profile_id', $id);
            })
            ->sum('subtotal');

        // Reviews
        $reviews = DB::table('reviews')
            ->join('order_items', 'reviews.order_item_id', '=', 'order_items.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_profile_id', $id)
            ->select(DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as total_reviews'))
            ->first();

        return view('admin.sellers.show', compact(
            'seller', 'products', 'orders', 'earnings', 'reviews'
        ));
    }
}
