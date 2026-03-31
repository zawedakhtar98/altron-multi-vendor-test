<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthControllerSanctum;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\PassportController;

Route::apiResource('auth', AuthControllerSanctum::class);
Route::post('register',[AuthControllerSanctum::class,'register']);
Route::post('login',[AuthControllerSanctum::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function(){
    Route::get('products/search',[ProductController::class,'search']);
    Route::apiResource('products',ProductController::class);
});

Route::prefix('auth')->name('auth.')->group(function(){
    Route::post('/register',[PassportController::class,'register']);  
    Route::post('/login',[PassportController::class,'login'])->middleware('throttle:login_attempts');        
    Route::post('logout',[PassportController::class,'logout']);       
});

Route::middleware('auth:api')->prefix('admin')->group(function(){
    Route::apiResource('product',ProductController::class);
    Route::get('categories',[ProductController::class,'getCategory']);
});

Route::get('/product-filter',[ProductController::class,'filterByProductAndCategory']);

Route::middleware('auth:api')->group(function(){
    Route::get('/test',[PassportController::class,'index'])->name('test');
});
