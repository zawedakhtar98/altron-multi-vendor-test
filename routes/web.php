<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

 Route::get('/',[CustomerController::class, 'product_list'])->name('product');
 Route::prefix('/cart')->middleware(['auth','customer'])->group(function(){
     Route::post('/add/{id}', [CustomerController::class, 'addToCart'])->name('cart.add');
     Route::get('/count', [CustomerController::class, 'cartCount'])->name('cart.count');
     Route::get('/view', [CustomerController::class, 'viewCart'])->name('cart.view');
     Route::post('/update', [CustomerController::class, 'updateCartItem'])->name('cart.update');
     Route::post('/remove/{id}', [CustomerController::class, 'removeCart'])->name('cart.remove');
     
});
Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout')->middleware(['auth','customer']);
Route::post('/order-place', [CustomerController::class, 'OrderPlace'])->name('order-place')->middleware(['auth','customer']);

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'verifyUser'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'SaveUsers'])->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/product-list', [AdminController::class, 'ProductList'])->name('admin.product-list');
    Route::get('/order-list', [AdminController::class, 'getAllOrders'])->name('admin.order-list');
    Route::get('orders/{id}/items', [AdminController::class, 'orderItems']);

});


Route::prefix('seller')->middleware(['auth','seller'])->group(function(){
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
   
    Route::prefix('/product')->group(function(){
        Route::get('/add', [SellerController::class, 'addProduct'])->name('seller.product.add');
        Route::post('/store', [SellerController::class, 'storeProduct'])->name('seller.product.store');
        Route::get('/list', [SellerController::class, 'ProductList'])->name('seller.product.list');
    });
});
