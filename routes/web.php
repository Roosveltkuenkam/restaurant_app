<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\Admin\AdminDashboardController;
use App\Http\Controllers\Web\Admin\UserController;

Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::middleware(['web.auth', 'web.role:ADMIN'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('admin/users', UserController::class)->names('admin.users');
});

Route::get('/', function () {
    return view('welcome');
});
