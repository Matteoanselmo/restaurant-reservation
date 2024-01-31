<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ReservationDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrenotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function index()
    {    $today = Carbon::now(); // Ottieni il mese attuale

        $resrvationDates = ReservationDate::with('bookings')
        ->whereDate('data', '>=', $today) // Seleziona date da oggi in poi
        ->whereHas('bookings', function ($query) {
            // Filtra i risultati in base alla presenza di almeno un booking
            $query->whereNotNull('id');
        })
        ->orderBy('data') // Ordina per data in ordine crescente
        ->get();

        return Inertia::render('Dashboard/Prenotazioni/Prenotazioni', [
            'prenotazioni' => $resrvationDates
        ]);
    }

    protected function oldPrenotations(){
        $today = Carbon::now(); // Ottieni il mese attuale

        $oldreservationDates = ReservationDate::with('bookings')
        ->whereDate('data', '<', $today) // Seleziona date da oggi in dietro
        ->orderBy('data') // Ordina per data in ordine crescente
        ->get();

        return Inertia::render('Dashboard/Prenotazioni/VecchiePrenotazioni', [
            'prenotazioni' => $oldreservationDates
        ]);
    }

    protected function show(Request $request){
        $reservationDate = ReservationDate::where('id', $request['id'])->select('id','titolo','data', 'pranzo_cena')->with('bookings')->first();
        //return response()->json($reservationDate);
        return Inertia::render('Dashboard/Prenotazioni/PrenotazioneShow', ['prenotazione' => $reservationDate]);
    }

}
