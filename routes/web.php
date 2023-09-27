<?php

use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\DateController;
use App\Http\Controllers\Guest\DateController as GuestDateController;
use App\Http\Controllers\Guest\PrenotationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard', [
            'data'=>Route::has('data')
        ]);
    })->name('dashboard');

    Route::get('/show-data/{data}', [DateController::class, 'show'])->name('dashboard.date.show');

    Route::get('/create-date/{data}', [DateController::class, 'create'])->name('dashboard.date.create');

    Route::get('/index-date', [DashBoardController::class, 'index'])->name('dashboard.date.index');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Scelta e Prenotazione
Route::get('/mare/data/{data}', [GuestDateController::class, 'showMare'])->name('guest.mare.show');
Route::get('/ci-dispiace/{data}', [GuestDateController::class, 'noDate'])->name('guest.no.date');
Route::get('/prenotazione/{data}', [PrenotationController::class, 'show'])->name('guest.prenotation');
Route::get('/scelta-posti/{id}', [PrenotationController::class, 'index'])->name('scelta.posti');

// Pagamenti
Route::get('pagamento', function () {
    return Inertia::render('Payments');
})->name('payment');

Route::get('grazie', function () {
    return Inertia::render('Thanks');
})->name('thanks.payment');

Route::get('errore-pagamento', function () {
    return Inertia::render('PaymentError');
})->name('error.payment');

require __DIR__.'/auth.php';
