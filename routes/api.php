<?php

use App\Http\Controllers\AdminLogController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthenticatedSessionController::class, 'apiStore'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/verify-token', [AuthenticatedSessionController::class, 'verifyToken'])->name('verifyToken');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::prefix('/products')->group(function () {
       Route::get('/', [ProductController::class, 'index'])->name('products.index');
       Route::post('/add-to-cart/{product}', [ProductController::class, 'addToCart'])->name('products.addToCart');
    });

    Route::prefix('/carts')->group(function () {
       Route::get('/', [CartController::class, 'show'])->name('cart.show');
       Route::post('/remove-from-cart/{cart}/{product}', [CartController::class, 'removeFromCart'])->name('cart.removeFromCart');
       Route::post('/buy/{cart}', [CartController::class, 'buy'])->name('cart.buy');
    });

    Route::prefix('/logs')->middleware('admin')->group(function () {
        Route::get('/', [AdminLogController::class, 'index'])->name('logs.index');
        Route::get('/actions', [AdminLogController::class, 'logsActions'])->name('logs.actions');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
