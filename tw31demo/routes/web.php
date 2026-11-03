<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('levels', LevelController::class);

    Route::resource('members', MemberController::class);

    Route::resource('transactions', TransactionController::class);

    Route::get(
        'payments/{payment}/receipt',
        [PaymentController::class, 'receipt']
    )->name('payments.receipt');

    Route::resource('payments', PaymentController::class);
});