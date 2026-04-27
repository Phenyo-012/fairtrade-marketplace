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
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\SellerCourierController;




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

    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.my');

    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');


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

    Route::post('/reviews/bulk', [ReviewController::class, 'bulkStore'])
        ->name('review.bulkStore');

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

    // CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');
    
    Route::post('/checkout/review', [CheckoutController::class, 'review'])
        ->name('checkout.review');

    Route::post('/checkout/payment/prepare', [CheckoutController::class, 'preparePayment'])
        ->name('checkout.payment.prepare');

    Route::get('/checkout/payment', [CheckoutController::class, 'showPayment'])
        ->name('checkout.payment');

    Route::post('/checkout/payment/confirm', [CheckoutController::class, 'confirmPayment'])
        ->name('checkout.payment.confirm');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    Route::get('/checkout/success/{orders}', [CheckoutController::class, 'success'])
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

    // CHAT ROUTES
    Route::get('/chat/start/{seller}', [ChatController::class, 'start'])
        ->name('chat.start');

    Route::get('/chat/{conversation}', [ChatController::class, 'show'])
        ->name('chat.show');

    Route::get('/chat', [ChatController::class, 'index'])
        ->name('chat.index');
    
    Route::post('/chat/{conversation}/send', [ChatController::class, 'send'])
        ->name('chat.send');

    Route::post('/chat/message/{message}/report', [ChatController::class, 'report'])
        ->name('chat.report');

    Route::post('/chat/block/{user}', [ChatController::class, 'block'])
        ->name('chat.block');

    // ARCHIVE PRODUCTS
    Route::patch('/products/{product}/archive', [ProductController::class, 'archive'])
        ->name('products.archive');

    Route::patch('/products/{product}/unarchive', [ProductController::class, 'unarchive'])
        ->name('products.unarchive');

    // CANCEL ORDER 
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');

    // CONTACT SUPPORT
    Route::get('/contact-support', [SupportController::class, 'create'])
        ->name('support.contact');

    Route::post('/contact-support', [SupportController::class, 'store'])
        ->name('support.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

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

    Route::get('/sellers/{seller}', [SellerVerificationController::class, 'show'])
        ->name('admin.sellers.show');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');

    Route::patch('/admin/orders/{order}/complete', [AdminOrderController::class, 'complete'])
        ->name('admin.orders.complete');

     Route::middleware('super.admin')->group(function () {
        Route::get('/create-admin', [App\Http\Controllers\Admin\AdminUserController::class, 'create'])
            ->name('admin.create');

        Route::post('/create-admin', [App\Http\Controllers\Admin\AdminUserController::class, 'store'])
            ->name('admin.store');
     });

    Route::get('/chats', [\App\Http\Controllers\Admin\AdminChatController::class, 'index'])
        ->name('admin.chats.index');

    Route::get('/chats/{conversation}', [\App\Http\Controllers\Admin\AdminChatController::class, 'show'])
        ->name('admin.chats.show');

    // SUPPORT ROUTES
    Route::get('/support-tickets', [SupportTicketController::class, 'index'])
    ->name('admin.support.index');

    Route::get('/support-tickets/{ticket}', [SupportTicketController::class, 'show'])
        ->name('admin.support.show');

    Route::patch('/support-tickets/{ticket}/status', [SupportTicketController::class, 'updateStatus'])
        ->name('admin.support.updateStatus');
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

    Route::get('/seller/guide', [App\Http\Controllers\SellerGuideController::class, 'index'])
        ->name('seller.guide');

    // COURIERS
    Route::get('/seller/orders/{order}/couriers', [SellerCourierController::class, 'index'])
        ->name('seller.orders.couriers');

    Route::get('/seller/orders/{order}/couriers/{courier}', [SellerCourierController::class, 'show'])
        ->name('seller.orders.couriers.show');

    Route::post('/seller/orders/{order}/couriers/{courier}/book', [SellerCourierController::class, 'book'])
        ->name('seller.orders.couriers.book');

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
        return view('buyer.dashboard');})
        ->name('buyer.dashboard');
});

require __DIR__.'/auth.php';