<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\KitchenController;
use App\Http\Controllers\Api\CashierReportController;
use App\Http\Controllers\Api\AuthController;

Route::post('v1/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('v1/auth/me', [AuthController::class, 'me']);
    Route::post('v1/auth/logout', [AuthController::class, 'logout']);
});
Route::middleware(['auth:sanctum','role:SERVEUR,CAISSE,ADMIN'])->group(function () {
    Route::post('v1/orders', [\App\Http\Controllers\Api\OrderController::class, 'store']);
    Route::get('v1/orders/{order}', [\App\Http\Controllers\Api\OrderController::class, 'show']);
});
Route::middleware(['auth:sanctum','role:CAISSE,ADMIN'])->group(function () {
    Route::post('v1/orders/{order}/payments', [\App\Http\Controllers\Api\PaymentController::class, 'store']);
});
Route::middleware(['auth:sanctum','role:CUISINE,ADMIN'])->group(function () {
    Route::get('v1/kitchen/queue', [\App\Http\Controllers\Api\KitchenController::class, 'queue']);
    Route::get('v1/kitchen/items', [\App\Http\Controllers\Api\KitchenController::class, 'index']);
    Route::patch('v1/kitchen/items/{orderItem}', [\App\Http\Controllers\Api\KitchenController::class, 'update']);
});
Route::middleware(['auth:sanctum','role:CAISSE,ADMIN'])->group(function () {
    Route::get('v1/cashier/payments', [\App\Http\Controllers\Api\CashierReportController::class, 'payments']);
    Route::get('v1/cashier/summary', [\App\Http\Controllers\Api\CashierReportController::class, 'summary']);
});

Route::get('v1/cashier/payments', [CashierReportController::class, 'payments']); // journal
Route::get('v1/cashier/summary', [CashierReportController::class, 'summary']);   // totaux

Route::get('v1/kitchen/items', [KitchenController::class, 'index']);                 // liste KDS
Route::patch('v1/kitchen/items/{orderItem}', [KitchenController::class, 'update']);  // update status
Route::get('v1/kitchen/queue', [KitchenController::class, 'queue']);

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
