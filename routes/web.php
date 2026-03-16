<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\MarketplaceController; 
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\CourierController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\AdminDisputeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketplaceController::class, 'index']);

Route::get('/products/{product}', [MarketplaceController::class, 'show']); 

Route::post('/products/{product}/buy', [OrderController::class, 'store'])
    ->middleware('auth');

Route::get('/orders', [OrderController::class, 'index'])
    ->middleware('auth');

Route::get('/my-orders', [App\Http\Controllers\OrderController::class, 'myOrders'])
    ->middleware('auth')
    ->name('orders.my');

Route::get('/courier/confirm-delivery', [CourierController::class, 'showForm']);

Route::post('/courier/confirm-delivery', [CourierController::class, 'confirmDelivery']);
    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products/create', 
    [ProductController::class, 'create'])->middleware('auth');
    
Route::post('/products', 
    [ProductController::class, 'store'])->middleware('auth');

Route::get('/products', 
    [ProductController::class, 'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/admin/products', [AdminProductController::class, 'index'])
        ->name('admin.products');

    Route::post('/admin/products/{id}/approve', [AdminProductController::class, 'approve'])
        ->name('admin.products.approve');
});

Route::middleware(['auth','role:seller'])->group(function () {
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});

Route::middleware(['auth','role:buyer'])->group(function () {
    Route::get('/buyer/dashboard', function () {
        return view('buyer.dashboard');
    })->name('buyer.dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/orders/{order}/dispute', [DisputeController::class, 'create'])
        ->name('disputes.create');

    Route::post('/orders/{order}/dispute', [DisputeController::class, 'store'])
        ->name('disputes.store');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/disputes', [AdminDisputeController::class, 'index'])
        ->name('admin.disputes');

    Route::get('/admin/disputes/{dispute}', [AdminDisputeController::class, 'show'])
        ->name('admin.disputes.show');

    Route::post('/admin/disputes/{dispute}/resolve', [AdminDisputeController::class, 'resolve'])
        ->name('admin.disputes.resolve');
});

Route::middleware('auth')->group(function () {

    Route::get('/orders/{order}/review',
        [ReviewController::class,'create'])
        ->name('reviews.create');

    Route::post('/orders/{order}/review',
        [ReviewController::class,'store'])
        ->name('reviews.store');

});