<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\TablePageController;

// Route::view('/', 'landing');
Route::middleware('guest')->group(function () {
    Route::view('/', 'pages/visitor/home')->name('home');
    Route::view('/login', 'login')->name('login');
    Route::post('/login/process', [LoginController::class, 'login']);
    Route::view('/register', 'register')->name('register');
    Route::post('/register/process', [RegisterController::class, 'register']);
    Route::view('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot/send-link', [ForgotController::class, 'sendResetLink'])->name('forgot.sendlink');
    Route::get('/password/reset/{token}', [ForgotController::class, 'reset'])->name('password.reset');
    Route::post('/password/reset/process', [ForgotController::class, 'resetProcess'])->name('reset.password');
});


Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::view('/dashboard', 'Pages/Admin/Dashboard')->name('dashboard');
        Route::get('/table/{filter_table?}', [TablePageController::class, 'getTable'])->name('table');
    });
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::view('/dashboard', 'pages/seller/dashboard')->name('dashboard');
        Route::view('/store/creation', 'pages/seller/StoreCreation')->name('store.creation');
        Route::post('/store/creation/process', [SellerStoreController::class, 'openStore'])->name('store.creation.process');
        Route::view('/products', 'pages/seller/MyProducts')->name('products');
        Route::view('/stores', 'pages/seller/MyStores')->name('stores');
        Route::view('/product/creation', 'pages/seller/ProductCreation')->name('product.creation');
        Route::view('/product/creation', 'pages/seller/ProductCreation')->name('product.creation.process');
    });
});
