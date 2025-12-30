<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    if (auth()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Auth routes (provided by Breeze)
require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard (redirects based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Menu
    Route::get('/menu', [ProductController::class, 'index'])->name('menu.index');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Orders
    Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
    Route::post('/orders/{order}/check-payment', [OrderController::class, 'checkPaymentStatus'])->name('orders.checkPayment');
    Route::get('/orders/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders');
});

// Cashier routes
Route::middleware(['auth', 'role:cashier,superadmin'])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/orders', [CashierController::class, 'index'])->name('orders');
    Route::get('/orders/all', [CashierController::class, 'allOrders'])->name('orders.all');
    Route::get('/orders/{order}', [CashierController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [CashierController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/mark-paid', [CashierController::class, 'markAsPaid'])->name('orders.markAsPaid');
    Route::post('/orders/{order}/mark-unpaid', [CashierController::class, 'markAsUnpaid'])->name('orders.markAsUnpaid');
    Route::get('/orders/{order}/receipt', [CashierController::class, 'receipt'])->name('orders.receipt');
});

// Admin routes
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/{product}/image', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
});
