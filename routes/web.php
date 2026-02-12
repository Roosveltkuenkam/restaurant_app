<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\Admin\AdminDashboardController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\OrderWebController;
use App\Http\Controllers\Web\OrdersUiController;
use App\Http\Controllers\Admin\ProductController;


Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::middleware(['web.auth', 'web.role:ADMIN'])->group(function () {
    
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('admin/users', UserController::class)->names('admin.users');
});


// Route::middleware(['web.auth'])->group(function () {
//     Route::get('/orders', [OrderWebController::class, 'index'])->name('orders.index');
//     Route::get('/orders/{order}', [OrderWebController::class, 'show'])->name('orders.show');
// });



Route::middleware(['web.auth'])->group(function () {
    Route::get('/orders-ui', [OrdersUiController::class, 'tables'])->name('orders.ui.tables');
    Route::get('/orders-ui/table/{table}', [OrdersUiController::class, 'takeTable'])->name('orders.ui.takeTable');

    // endpoints AJAX (web) pour alimenter l’UI
    Route::get('/orders-ui/table/{table}/catalog', [OrdersUiController::class, 'catalog'])->name('orders.ui.catalog');
});


Route::middleware(['web.auth'])->group(function () {
    Route::get('/orders', [OrderWebController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderWebController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderWebController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderWebController::class, 'show'])->name('orders.show');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');
});



Route::get('/', function () {
    return view('welcome');
});
