<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['guestOrVerified'])->group(function (){
    /**Product*/
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

    /**Cart*/
    Route::prefix('/cart')->name('cart.')->group(function (){
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product:slug}',               [CartController::class, 'add'])->name('add');
        Route::post('/remove/{product:slug}',            [CartController::class, 'remove'])->name('remove');
        Route::post('/update-quantity/{product:slug}',   [CartController::class, 'updateQuantity'])->name('update-quantity');
    });
});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    /**Profile*/
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'post'])->name('profile.update');
    Route::post('/profile/password-update', [ProfileController::class, 'passwordUpdate'])->name('profile_password.update');

    /**Checkout*/
    Route::post('/checkout', [CheckoutController::class,'checkout'])->name('checkout');
    Route::post('/checkout/{order}', [CheckoutController::class,'checkoutOrder'])->name('checkout-order');
    Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');

    /**Order*/
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.show');

});

/**WebHook*/
Route::post('webhook/stripe', [CheckoutController::class, 'webhook'])->name('webhook.stripe');

require __DIR__.'/auth.php';

