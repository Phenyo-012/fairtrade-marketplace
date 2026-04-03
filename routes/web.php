<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\AdminDisputeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\ReviewVoteController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [MarketplaceController::class, 'index']);
Route::get('/products/{product}', [MarketplaceController::class, 'show']);

// Courier
Route::get('/courier/confirm-delivery', [CourierController::class, 'showForm'])
    ->name('courier.form');

Route::post('/courier/confirm-delivery', [CourierController::class, 'confirm'])
    ->name('courier.confirm');

Route::post('/reviews/{review}/vote', [ReviewVoteController::class, 'vote'])
    ->name('reviews.vote')
    ->middleware('auth');
/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Orders
    Route::post('/products/{product}/buy', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.my');

    // Buyer Disputes
    Route::get('/orders/{order}/dispute', [DisputeController::class, 'create'])
        ->name('disputes.create');

    Route::post('/orders/{order}/dispute', [DisputeController::class, 'store'])
        ->name('disputes.store');

    // Reviews
    Route::get('/orders/{order}/review', [ReviewController::class,'create'])
        ->name('reviews.create');

    Route::post('/review/{orderItem}', [ReviewController::class, 'store'])
        ->name('review.store');

    // Shopping Cart
    Route::post('/cart/{product}', [CartController::class, 'add'])
        ->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');
    Route::patch('/cart/{item}', [CartController::class, 'update'])
        ->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])
        ->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])
        ->name('cart.clear');

    // CHECKOUT ROUTES
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
        ->name('checkout.success');

    Route::get('/marketplace', [MarketplaceController::class, 'index'])
        ->name('marketplace.index');
        
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Product Approval
    Route::get('/admin/products', [AdminProductController::class, 'index'])
        ->name('admin.products');

    Route::post('/admin/products/{id}/approve', [AdminProductController::class, 'approve'])
        ->name('admin.products.approve');

    // Admin Disputes Management
    Route::get('/admin/disputes', [AdminDisputeController::class, 'index'])
        ->name('admin.disputes');

    Route::get('/admin/disputes/{dispute}', [AdminDisputeController::class, 'show'])
        ->name('admin.disputes.show');

    Route::post('/admin/disputes/{dispute}/resolve', [AdminDisputeController::class, 'resolve'])
        ->name('admin.disputes.resolve');
});

/*
|--------------------------------------------------------------------------
| SELLER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:seller'])->group(function () {

    // Seller Dashboard
    Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])
        ->name('seller.dashboard');

    // Product Manager
    Route::resource('seller/products', SellerProductController::class)
        ->names('seller.products');

    Route::get('/seller/orders', [SellerOrderController::class, 'index'])
        ->name('seller.orders.index');

    Route::get('/seller/orders/{order}', [SellerOrderController::class, 'show'])
        ->name('seller.orders.show');

    Route::patch('/seller/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])
        ->name('seller.orders.updateStatus');

});

/*
|--------------------------------------------------------------------------
| BUYER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:buyer'])->group(function () {

    Route::get('/buyer/dashboard', function () {
        return view('buyer.dashboard');
    })->name('buyer.dashboard');
});

require __DIR__.'/auth.php';