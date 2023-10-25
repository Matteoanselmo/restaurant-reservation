<?php

use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReservationDateController;
use App\Http\Controllers\Api\ShowTypeController;
use App\Http\Controllers\Api\StriperController;
use App\Models\ReservationDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stripe\Stripe;
use Stripe\PaymentIntent;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your Api!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/reservation-dates', [ReservationDateController::class, 'store']);
    Route::get('/show-types', [ShowTypeController::class, 'index']);
    Route::delete('/delete-data/{id}', [ReservationDateController::class, 'destroy']);
    Route::post('/get-all-reservation-dates/{month}/', [ReservationDateController::class, 'allMonthDate']);
    Route::post('/send-newsletter', [NewsLetterController::class, 'sendNewsletter']);
    Route::post('/create-artist', [ArtistController::class, 'store']);
    Route::post('/filtered-artist-title/{show_type_id}', [ArtistController::class, 'getArtistTitoloByType']);
});

// Route::post('payment/initiate', [PaymentController::class, 'index'])->name('payment.initiate');
Route::post('payment/initiate', [StriperController::class, 'initiatePayment']);
Route::post('payment/complete', [StriperController::class, 'completePayment']);
Route::post('payment/failure', [StriperController::class, 'failPayment']);

Route::post('/get-reservation-dates/{month}/{showTypeId}', [ReservationDateController::class, 'index']);

//Artisti
Route::post('/filtered-artist/{show_type_id}', [ArtistController::class, 'getArtistByType']);
