<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;

Route::prefix('v1')->group(function () {
    // Orders
    Route::post('/orders', [OrderController::class, 'store']);          // create order
    Route::get('/orders/{order}', [OrderController::class, 'show']);    // show order

    // Payments
    Route::post('/orders/{order}/payments', [PaymentController::class, 'store']); // pay order (split supported)
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
