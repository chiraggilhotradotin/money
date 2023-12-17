<?php

use App\Http\Controllers\Auth\CallbackController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RedirectController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', [HomeController::class, 'home'])->name('home');
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
        Route::get('google', [LoginController::class, 'google'])->name('google');
    });
    Route::group(['prefix' => 'callback', 'as' => 'callback.'], function () {
        Route::get('google', [CallbackController::class, 'google'])->name('google');
    });
});
Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('redirect_to_dashboard', [RedirectController::class, 'redirect_to_dashboard'])->name('redirect_to_dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('businesses', [BusinessController::class, 'index'])->name('businesses');
    Route::group(['as' => 'customers', 'prefix' => 'customers'], function () {
        Route::get('', [CustomerController::class, 'index'])->name('');
        Route::match(['get','post'],'add', [CustomerController::class, 'add'])->name('.add');
        Route::match(['get','post'],'{customer_uuid}/edit', [CustomerController::class, 'edit'])->name('.edit');
        Route::get('{customer_uuid}/delete', [CustomerController::class, 'delete'])->name('.delete');
        Route::get('{customer_uuid}', [CustomerController::class, 'show'])->name('.show');
    });
    Route::group(['as' => 'transactions.', 'prefix' => 'transactions'], function () {
        Route::match(['get','post'],'{customer_uuid}/add', [TransactionController::class, 'add'])->name('add');
        Route::get('{customer_uuid}/{transaction_uuid}/approve', [TransactionController::class, 'approve'])->name('approve');
        Route::match(['get','post'],'{customer_uuid}/{transaction_uuid}/edit', [TransactionController::class, 'edit'])->name('edit');
        Route::get('{customer_uuid}/{transaction_uuid}/delete', [TransactionController::class, 'delete'])->name('delete');
    });
});
