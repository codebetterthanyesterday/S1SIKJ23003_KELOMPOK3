<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\TablePageController;
use App\Http\Controllers\Admin\CreationPageController;
use App\Http\Controllers\Customer\ProductCategoryController;
use App\Http\Controllers\Admin\ProductCategoryController as AdminProductCategoryController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\SearchController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Visitor\ProfileController;
use Illuminate\Support\Facades\Auth;

// Route::view('/', 'landing');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [CustomerProductController::class, 'showProduct'])->name('product.show');
Route::get('/store/{slug}', [\App\Http\Controllers\Customer\StoreController::class, 'show'])->name('store.show');
Route::get('/live-search', [SearchController::class, 'liveSearch'])->name('live.search');
Route::get('/cart', [CustomerCartController::class, 'index'])->name('cart.index');
Route::get('/category/{category_slug?}', [CustomerProductController::class, 'getProductByCategory'])->name('category.getproduct');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('/forgot/process', [AuthController::class, 'sendResetLink'])->name('forgot.process');
Route::get('/password/reset/{token}', [AuthController::class, 'reset'])->name('password.reset');
Route::post('/password/reset/process', [AuthController::class, 'doReset'])->name('password.reset.process');
Route::post('/login/process', [AuthController::class, 'doLogin'])->name('login.process');
Route::post('/register/process', [AuthController::class, 'doRegister'])->name('register.process');
// Route::middleware('guest')->group(function () {
// });


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'doLogout'])->name('logout');
    Route::put('/user/change-password/{id}', [AuthController::class, 'doChangePassword'])->name('change.password');
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/profile', [AdminController::class, 'getProfile'])->name('profile');
        Route::get('/table/{entity}', [AdminController::class, 'getList'])->name('table');
        Route::get('/creation/{entity}', [AdminController::class, 'getCreationPage'])->name('creation');
        Route::post('/creation/{entity}/process', [AdminController::class, 'handleCreation'])->name('creation.process');
    });
    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/salesdata', [SellerController::class, 'salesData'])->name('dashboard.salesdata');
        Route::get('/dashboard/recentorders', [SellerController::class, 'recentOrders'])->name('dashboard.recentorders');
        Route::get('/dashboard/comparisondata', [SellerController::class, 'comparisonData'])->name('dashboard.comparisondata');
        Route::get('/{entity}/creation', [SellerController::class, 'getCreation'])->name('creation');
        Route::get('/{entity}/list', [SellerController::class, 'getList'])->name('list');
        Route::post('/store/creation/process', [SellerStoreController::class, 'openStore'])->name('store.creation.process');
        Route::get('/products/search', [SellerProductController::class, 'search'])->name('products.search');
        Route::get('/products', [SellerProductController::class, 'index'])->name('products.list');
        Route::get('/products/filter', [SellerProductController::class, 'filter'])->name('products.filter');
        Route::get('/products/export', [App\Http\Controllers\Seller\ExportController::class, 'exportProducts'])->name('products.export');
        Route::get('/categories/manage', [SellerProductController::class, 'manageCategories'])->name('categories.manage');
        Route::get('products/{product?}', [SellerProductController::class, 'show'])->name('product.show');
        Route::get('/stores', [SellerStoreController::class, 'index'])->name('stores.list');
        Route::get('products/{product}/edit', [SellerProductController::class, 'edit'])->name('product.edit');
        Route::put('products/{product}', [SellerProductController::class, 'update'])->name('product.update');
        Route::delete('products/{product}', [SellerProductController::class, 'destroy'])->name('product.destroy');
        Route::get('stores/{store?}', [SellerStoreController::class, 'show'])->name('store.show');
        Route::get('stores/{store}/edit', [SellerStoreController::class, 'edit'])->name('store.edit');
        Route::put('stores/{store}', [SellerStoreController::class, 'update'])->name('store.update');
        Route::delete('stores/{store}', [SellerStoreController::class, 'deleteStore'])->name('store.destroy');
        Route::post('/products', [SellerProductController::class, 'makeProduct'])->name('product.store');

        // Order Management Routes
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/filter', [SellerOrderController::class, 'filterOrders'])->name('orders.filter');
        Route::get('/orders/search', [SellerOrderController::class, 'searchOrders'])->name('orders.search');
        Route::post('/orders/{orderId}/approve', [SellerOrderController::class, 'approveOrder'])->name('orders.approve');
        Route::post('/orders/{orderId}/reject', [SellerOrderController::class, 'rejectOrder'])->name('orders.reject');
        Route::post('/orders/{orderId}/ship', [SellerOrderController::class, 'markAsShipped'])->name('orders.ship');
        Route::post('/orders/{orderId}/deliver', [SellerOrderController::class, 'markAsDelivered'])->name('orders.deliver');
        Route::get('/orders/export', [App\Http\Controllers\Seller\ExportController::class, 'exportOrders'])->name('orders.export');
    });
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::post('/cart/increment/{cartItem}', [
            CustomerCartController::class,
            'incrementCartItem'
        ])->name('cart.increment');
        Route::post('/cart/decrement/{cartItem}', [
            CustomerCartController::class,
            'decrementCartItem'
        ])->name('cart.decrement');
        Route::delete('/cart/remove/{id}', [CustomerCartController::class, 'removeCartItem'])->name('cart.remove');
        Route::post('/cart/add/{product}', [CustomerCartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CustomerCartController::class, 'updateCart'])->name('cart.update');
        Route::post('/checkout/store/{storeId}', [CustomerCartController::class, 'checkoutStore'])->name('checkout.store');

        // Payment routes
        Route::get('/payment/{orderId}', [\App\Http\Controllers\Customer\PaymentController::class, 'showPaymentPage'])->name('payment.show');
        Route::post('/payment/{orderId}/method', [\App\Http\Controllers\Customer\PaymentController::class, 'processPaymentMethod'])->name('payment.method');
        Route::get('/payment/{orderId}/details/{method}', [\App\Http\Controllers\Customer\PaymentController::class, 'showPaymentDetails'])->name('payment.details');
        Route::post('/payment/{orderId}/confirm', [\App\Http\Controllers\Customer\PaymentController::class, 'confirmPayment'])->name('payment.confirm');
        Route::get('/payment/{orderId}/confirmation', [\App\Http\Controllers\Customer\PaymentController::class, 'showConfirmation'])->name('payment.confirmation');
        Route::get('/orders/history', [\App\Http\Controllers\Customer\PaymentController::class, 'orderHistory'])->name('orders.history');
        Route::post('/orders/{orderId}/cancel', [\App\Http\Controllers\Customer\PaymentController::class, 'cancelOrder'])->name('orders.cancel');
    });
});

// Visitor Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('visitor.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('visitor.profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('visitor.profile.password');
});

Route::get('/api/cart/count', function () {
    $user = Auth::user();
    $count = 0;
    if ($user) {
        $count = App\Models\CartItem::whereHas('cartGroup', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->sum('quantity');
    }
    return response()->json(['count' => $count]);
});
