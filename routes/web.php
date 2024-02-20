<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Support\Storage\Contract\StorageInterface;
use App\Support\Storage\SessionStorage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{product}/add', [BasketController::class, 'add'])->name('basket.add');
Route::get('basket', [BasketController::class, 'index'])->name('basket.index');
Route::post('basket/{product}/update', [BasketController::class, 'update'])->name('basket.update');
Route::get('basket/checkout', [BasketController::class, 'checkoutForm'])->name('basket.checkout.form');
Route::post('basket/checkout', [BasketController::class, 'checkout'])->name('basket.checkout');
Route::post('payment/{gateway}/callback', [PaymentController::class, 'verify'])->name('payment.verify');
Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
Route::get('coupons', [CouponController::class, 'remove'])->name('coupons.remove');
Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('invoice/{order}', [InvoiceController::class, 'show'])->name('invoice.show');
Route::get('orders/pay/{order}', [OrdersController::class, 'pay'])->name('order.pay');

Route::get('basket/clear', function(){
    resolve(StorageInterface::class)->clear();
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
