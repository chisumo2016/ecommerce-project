<?php

use App\Http\Controllers\CartController;
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
        Route::post('/update-quantity/{product:slug}',   [CartController::class, 'updateQuantity'])->name('updated-quantity');
    });
});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
