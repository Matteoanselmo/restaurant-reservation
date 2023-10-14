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
    {    $today = Carbon::now(); // Ottieni la data e l'ora attuali

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
        $today = Carbon::now(); // Ottieni la data e l'ora attuali

        $oldreservationDates = ReservationDate::with('bookings')
        ->whereDate('data', '<', $today) // Seleziona date da oggi in poi
        ->orderBy('data') // Ordina per data in ordine crescente
        ->get();

        return Inertia::render('Dashboard/Prenotazioni/VecchiePrenotazioni', [
            'prenotazioni' => $oldreservationDates
        ]);
    }

}
