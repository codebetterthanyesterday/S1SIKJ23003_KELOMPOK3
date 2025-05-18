<?php

use App\Http\Controllers\ForgotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoreController;

Route::view('/', 'landing');

Route::view('/home', 'pages/visitor/home')->name('home');

Route::middleware('guest')->group(function () {
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
    Route::view('/admin/dashboard', 'Pages/Admin/Dashboard')->name('admindashboard');
    Route::get('/ctm/page/home', function () {
        return view('customerpages/home');
    })->name('ctm.page.home');
    Route::view('/seller/dashboard', 'pages/seller/dashboard')->name('sellerdashboard');
    Route::view('/seller/store/creation', 'pages/seller/StoreCreation')->name('store.creation');
    Route::post('/seller/store/creation/process', [StoreController::class, 'openStore'])->name('store.creation.process');
    Route::view('/seller/products', 'pages/seller/MyProducts')->name('sellerproducts');
    Route::view('/seller/stores', 'pages/seller/MyStores')->name('sellerstores');
    Route::view('/seller/product/creation', 'pages/seller/ProductCreation')->name('product.creation');
    // Route::post(
        //     '/page/store-creation/process',
        //     [StoreController::class, 'createStore']
        // )->name('storecreate.process');

    // Route::get(
    //     '/page/store-creation',
    //     [StoreController::class, 'createView']
    // )->name('storecreate.view');
    // Form buka toko
    Route::get('/stores/open', [StoreController::class, 'openForm'])
        ->name('stores.open.form');

    // Proses buka toko
    Route::post('/stores/open', [StoreController::class, 'openStore'])
        ->name('stores.open');
    Route::get('/ctm/page/explore', function () {
        return view('customerpages/explore');
    })->name('ctm.page.explore');
    Route::get('/ctm/page/store', function () {
        return view('customerpages/store');
    })->name('ctm.page.store');
    Route::get('/ctm/page/sale', function () {
        return view('customerpages/sale');
    })->name('ctm.page.sale');
    Route::get('/ctm/page/cart', function () {
        return view('customerpages/cart');
    })->name('ctm.page.cart');
    Route::get('/ctm/page/favorited-store', function () {
        return view('customerpages/favoritedStore');
    })->name('ctm.page.favorited-store');
    Route::get('/ctm/page/product/{slug}', [ProductController::class, 'show/$slug'])->name('ctm.page.product');
});
