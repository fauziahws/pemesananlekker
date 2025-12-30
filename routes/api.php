<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    // Products API
    Route::get('/products', [OrderController::class, 'apiProducts']);

    // Cart API
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/update', [CartController::class, 'update']);
    Route::post('/cart/remove', [CartController::class, 'remove']);

    // Orders API
    Route::post('/orders', [OrderController::class, 'apiStore']);

    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
