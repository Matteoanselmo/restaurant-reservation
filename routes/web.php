<?php

use App\Http\Controllers\Admin\ArtistiController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\DateController;
use App\Http\Controllers\Admin\PrenotationController as AdminPrenotationController;
use App\Http\Controllers\Admin\ResocontoController;
use App\Http\Controllers\Admin\RubricaController;
use App\Http\Controllers\Guest\DateController as GuestDateController;
use App\Http\Controllers\Guest\PrenotationController;
use App\Http\Controllers\ProfileController;
use App\Mail\GuestConfirmedPayment;
use App\Mail\NewsletterMail;
use App\Models\Client;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
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
// Dashboard Amministratore
Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard', [
            'data' => Route::has('data')
        ]);
    })->name('dashboard');

    // Date
    Route::get('/show-data/{data}', [DateController::class, 'show'])->name('dashboard.date.show');
    Route::get('/create-date/{data}', [DateController::class, 'create'])->name('dashboard.date.create');
    Route::get('/index-date', [DashBoardController::class, 'index'])->name('dashboard.date.index');

    // Rubrica
    Route::get('/rubrica', [RubricaController::class, 'index'])->name('dashboard.rubrica.index');
    Route::get('/rubrica/{id}', [RubricaController::class, 'show'])->name('dashboard.rubrica.show');

    //Prenotazioni
    Route::get('/prenotazioni', [AdminPrenotationController::class, 'index'])->name('dashboard.prenotazioni.index');
    Route::get('/prenotazioni-scadute', [AdminPrenotationController::class, 'oldPrenotations'])->name('dashboard.prenotazioni.scadute');
    Route::get('/edit-booked', [AdminPrenotationController::class, 'show'])->name('dashboard.prenotazioni.prenotati');

    //Resoconto
    Route::get('/resoconto', [ResocontoController::class, 'index'])->name('dashboard.resoconto.index');

    //NewsLetter
    Route::get('/newsletter', [DashBoardController::class, 'newsLetter'])->name('dashboard.newsletter');

    //Artisti
    Route::get('/artisti', [ArtistiController::class, 'index'])->name('dashboard.artists.index');
    Route::get('/aggiungi/artista', [ArtistiController::class, 'create'])->name('dashboard.artists.create');
});


// Dashboard Amministratore
Route::middleware('auth')->group(function () {
    // profilo
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Scelta e Prenotazione
Route::get('/spettacolo/data/{data}', [GuestDateController::class, 'selectShowFromData'])->name('guest.select.show');
Route::get('/ci-dispiace/{data}', [GuestDateController::class, 'noDate'])->name('guest.no.date');
Route::get('/prenotazione/{data}', [PrenotationController::class, 'show'])->name('guest.prenotation');
Route::get('/scelta-posti/{id}', [PrenotationController::class, 'index'])->name('scelta.posti');
Route::get('crea-menu', [GuestDateController::class, 'createIndexMenu'])->name('create.menu');

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

// Route::get('email', function() {
//     $message = 'ciao ciao ciao ';
//     // Mail::to('matteo.anselmo96@gmail.com')->send(new GuestConfirmedPayment($data));
//     // // Recupera la lista delle email dei clienti da qualche parte
//     $clientEmails = Client::pluck('email')->toArray();

//     // // // Invia la newsletter a tutte le email dei clienti
//     foreach ($clientEmails as $email) {
//         Mail::to($email)->send(new NewsletterMail($message));
//     }

//     return view('emails.Newsletter', compact('message'));
// });

require __DIR__ . '/auth.php';
