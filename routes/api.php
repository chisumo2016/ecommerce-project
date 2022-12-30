<?php
declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['auth:sanctum', 'admin'])
    ->group(function (){
        Route::get('/user',     [AuthController::class, 'getUser']);
        Route::post('/logout',  [AuthController::class, 'logout']);

    /**Product Route Resource**/
        Route::apiResource('products', ProductController::class);

    /**User Route Resource**/
       // Route::apiResource('users', UserController::class);

    /**Order Route Resource**/
        Route::get('orders',         [OrderController::class ,'index']);
        Route::get('orders/statuses', [OrderController::class, 'getStatuses']);
        Route::post('orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
        Route::get('orders/{order}', [OrderController::class, 'show']);

   /**Users Route Resource**/
        Route::apiResource('users', UserController::class);

   /**Customers Route Resource**/
        Route::apiResource('customers', CustomerController::class);

});

Route::post('/login',     [AuthController::class, 'login']);

