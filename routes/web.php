<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/book/{book}', [BookController::class, 'show'])->name('books.show');

Route::middleware('auth')->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('add', [CartController::class, 'add'])->name('add');
        Route::patch('update', [CartController::class, 'update'])->name('update');
        Route::delete('remove', [CartController::class, 'remove'])->name('remove');
    });

    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('my-orders.index');
});
