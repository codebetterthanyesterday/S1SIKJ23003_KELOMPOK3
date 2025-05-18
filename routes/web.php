<?php

use App\Http\Controllers\ForgotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoreController;

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
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::view('/admin/dashboard', 'Pages/Admin/Dashboard')->name('admin.dashboard');
    Route::view('/admin/table', 'Pages/Admin/Table')->name('admin.table');
    Route::view('/seller/dashboard', 'pages/seller/dashboard')->name('sellerdashboard');
    Route::view('/seller/store/creation', 'pages/seller/StoreCreation')->name('store.creation');
    Route::post('/seller/store/creation/process', [StoreController::class, 'openStore'])->name('store.creation.process');
    Route::view('/seller/products', 'pages/seller/MyProducts')->name('sellerproducts');
    Route::view('/seller/stores', 'pages/seller/MyStores')->name('sellerstores');
    Route::view('/seller/product/creation', 'pages/seller/ProductCreation')->name('product.creation');
});
