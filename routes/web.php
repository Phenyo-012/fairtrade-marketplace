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
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SellerStoreController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\Admin\SellerVerificationController;
use App\Http\Controllers\Admin\ReviewModerationController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HomeController;



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/marketplace', [MarketplaceController::class, 'index'])
        ->name('marketplace');

    Route::get('/marketplace', [MarketplaceController::class, 'index'])
        ->name('marketplace.index');

    Route::get('/products/{product}', [MarketplaceController::class, 'show']);

    // Courier
    Route::get('/courier/confirm-delivery', [CourierController::class, 'showForm'])
        ->name('courier.form');

    Route::post('/courier/confirm-delivery', [CourierController::class, 'confirm'])
        ->name('courier.confirm');

    Route::post('/reviews/{review}/vote', [ReviewVoteController::class, 'vote'])
        ->name('reviews.vote')
        ->middleware('auth');

   Route::get('/store/{seller}', [StoreController::class, 'show'])
        ->name('store.show');

    // seller reviews page
    Route::get('/store/{seller}/reviews', [StoreController::class, 'reviews'])
        ->name('store.reviews');

    Route::view('/terms', 'legal.terms')->name('terms');

    Route::view('/privacy', 'legal.privacy')->name('privacy');

    Route::view('/refund', 'legal.refund')->name('refund');
        
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

    Route::get('/disputes/{dispute}', [DisputeController::class, 'show'])
        ->name('disputes.show');
    
    Route::get('/seller/disputes', [\App\Http\Controllers\SellerDisputeController::class, 'index'])
        ->name('seller.disputes.index');

    Route::get('/seller/disputes/{dispute}', [\App\Http\Controllers\SellerDisputeController::class, 'show'])
        ->name('seller.disputes.show');

    Route::post('/seller/disputes/{dispute}/respond', [\App\Http\Controllers\SellerDisputeController::class, 'respond'])
        ->name('seller.disputes.respond');

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

    // SELLER STORE SETUP
    Route::get('/become-seller', [SellerProfileController::class, 'create'])
        ->name('seller.setup');

    Route::post('/become-seller', [SellerProfileController::class, 'store'])
        ->name('seller.store');

    // EDIT SELLER STORE
    Route::get('/seller/store/edit', [SellerProfileController::class, 'edit'])
        ->name('seller.store.edit');

    Route::post('/seller/store/update', [SellerProfileController::class, 'update'])
        ->name('seller.store.update');

    // Pending Verification Page
    Route::get('/seller/pending', function () {
        return view('seller.pending');
    })->name('seller.pending')->middleware('auth');

    // WISHLIST 
    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');

    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');

    /* Route::get('/seller/verify', [SellerProfileController::class, 'showKyc'])
        ->name('seller.kyc');

    Route::post('/seller/verify', [SellerProfileController::class, 'submitKyc'])
        ->name('seller.kyc.submit'); */

    // SELLER ONBOARDING
    Route::get('/seller/onboarding', [SellerProfileController::class, 'onboarding'])
        ->name('seller.onboarding');

    Route::post('/seller/onboarding/store', [SellerProfileController::class, 'storeStep']);

    Route::post('/seller/onboarding/kyc', [SellerProfileController::class, 'kycStep']);
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Product Approval
    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('admin.products');

    Route::post('/products/{id}/approve', [AdminProductController::class, 'approve'])
        ->name('admin.products.approve');

    // Admin Disputes Management
    Route::get('/disputes', [AdminDisputeController::class, 'index'])
        ->name('admin.disputes');

    Route::get('/disputes/{dispute}', [AdminDisputeController::class, 'show'])
        ->name('admin.disputes.show');

    Route::post('/disputes/{dispute}/resolve', [AdminDisputeController::class, 'resolve'])
        ->name('admin.disputes.resolve');

    // Review Moderation
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewModerationController::class, 'index'])
        ->name('admin.reviews');

    Route::get('/reviews/archive', [\App\Http\Controllers\Admin\ReviewModerationController::class, 'archive'])
        ->name('admin.reviews.archive');

    Route::get('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewModerationController::class, 'show'])
        ->name('admin.reviews.show');

    Route::patch('/reviews/{review}/approve', [\App\Http\Controllers\Admin\ReviewModerationController::class, 'approve'])
        ->name('admin.reviews.approve');

    Route::patch('/reviews/{review}/reject', [\App\Http\Controllers\Admin\ReviewModerationController::class, 'reject'])
        ->name('admin.reviews.reject');

    // SELLER VERIFICATION
    Route::get('/sellers', [SellerVerificationController::class, 'index'])
        ->name('admin.sellers.index');

    Route::post('/sellers/{seller}/approve', [SellerVerificationController::class, 'approve'])
        ->name('admin.sellers.approve');

    Route::post('/sellers/{seller}/reject', [SellerVerificationController::class, 'reject'])
        ->name('admin.sellers.reject');

});

/*
|--------------------------------------------------------------------------
| SELLER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:seller', 'seller.approved'])->group(function () {

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
| SELLER APPLICATION ROUTES
|--------------------------------------------------------------------------
*/  
Route::middleware(['auth', 'not.seller'])->group(function () {

    Route::get('/become-seller', [SellerProfileController::class, 'create'])
        ->name('seller.setup');

    Route::post('/become-seller', [SellerProfileController::class, 'store'])
        ->name('seller.store');

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