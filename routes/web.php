<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Admins\AdminsController;

use Illuminate\Support\Facades\Auth;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');

Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/services', [App\Http\Controllers\HomeController::class, 'services'])->name('services');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');



// products

Route::get('products/product-single/{id}', [ProductsController::class, 'singleProduct'])->name('product.single');
Route::post('products/product-single/{id}', [ProductsController::class, 'addCart'])->name('add.cart');
Route::get('products/cart', [ProductsController::class, 'cart'])->name('cart')->middleware("auth:web");
Route::get('products/cart-delete/{id}', [ProductsController::class, 'deleteProductCart'])->name('delete.product.cart');


// checkout

Route::post('products/prepare-checkout', [ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');
Route::get('products/checkout', [ProductsController::class, 'checkout'])->name('checkout')->middleware('check.for.price');
Route::post('products/checkout', [ProductsController::class, 'storeCheckout'])->name('process.checkout')->middleware('check.for.price');

Route::get('products/pay', [ProductsController::class, 'payWithPaypal'])->name('products.pay')->middleware('check.for.price');
Route::get('products/success', [ProductsController::class, 'success'])->name('products.pay.success')->middleware('check.for.price');



Route::post('products/book-table', [ProductsController::class, 'bookTables'])->name('booking.tables');


//menu
Route::get('products/menu', [ProductsController::class, 'menu'])->name('products.menu');

// my orders


Route::get('users/orders', [UsersController::class, 'displayOrders'])->name('users.orders');
Route::get('users/bookings', [UsersController::class, 'displayBookings'])->name('users.bookings');
Route::get('users/write-reviews', [UsersController::class, 'writeReview'])->name('write.reviews');
Route::post('users/write-reviews', [UsersController::class, 'processWriteReview'])->name('process.write.reviews');



// admins

Route::get('admins/login', [AdminsController::class, 'viewLogin'])->name('view.login')->middleware('check.for.auth');
Route::post('admins/login', [AdminsController::class, 'checkLogin'])->name('check.login');

Route::group(["prefix" => "admins", "middleware" => 'auth:admin'], function () {
    Route::get('/dashboard', [AdminsController::class, 'index'])->name('admins.dashboard');
    //display admins
    Route::get('/all-admins', [AdminsController::class, 'viewAdmins'])->name('all.admins');

    //create admins
    Route::get('/create-admins', [AdminsController::class, 'createAdmins'])->name('create.admins');
    Route::post('/create-admins', [AdminsController::class, 'storeAdmins'])->name('store.admins');

    //orders
    Route::get('/all-orders', [AdminsController::class, 'allOrders'])->name('show.orders');
    Route::get('/delete-orders', [AdminsController::class, 'deleteOrders'])->name('delete.order');
    Route::get('/change-orders/{id}', [AdminsController::class, 'changeOrders'])->name('change.order');
    Route::post('/change-orders/{id}', [AdminsController::class, 'updateOrders'])->name('update.order');



    // products
    Route::get('/all-product', [AdminsController::class, 'allProducts'])->name('show.products');
    Route::get('/create-product', [AdminsController::class, 'createProduct'])->name('create.product');
    Route::post('/create-product', [AdminsController::class, 'storeProduct'])->name('store.product');
    Route::get('/detele-product/{id}', [AdminsController::class, 'deleteProduct'])->name('delete.product');


    //bookings
    Route::get('/all-bookings', [AdminsController::class, 'allBookings'])->name('show.bookings');
});
