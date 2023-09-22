<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\API\ReservationDateController;
use App\Http\Controllers\API\ShowTypeController;
use App\Http\Controllers\API\StriperController;
use App\Models\ReservationDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stripe\Stripe;
use Stripe\PaymentIntent;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/reservation-dates', [ReservationDateController::class, 'store']);
    Route::get('/show-types', [ShowTypeController::class, 'index']);
    Route::delete('/delete-data/{id}', [ReservationDateController::class, 'destroy']);
});

// Route::post('payment/initiate', [PaymentController::class, 'index'])->name('payment.initiate');
Route::post('payment/initiate', [StriperController::class, 'initiatePayment']);
Route::post('payment/complete', [StriperController::class, 'completePayment']);
Route::post('payment/failure', [StriperController::class, 'failPayment']);

Route::post('/get-reservation-dates/{month}', [ReservationDateController::class, 'index']);
