<?php

use App\Http\Controllers\OrderBookingController;
use Illuminate\Http\Request;
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

Route::group(['namespace' => 'api'], function() {
    Route::post('/getData', [OrderBookingController::class, 'getData']);
    Route::post('/createOrder', [OrderBookingController::class, 'createOrder']);
    Route::post('/updateOrder', [OrderBookingController::class, 'updateOrder']);
    Route::post('/cancelOrder', [OrderBookingController::class, 'cancelOrder']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
