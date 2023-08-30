<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReservationDate;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

class DateController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    protected $monthTranslations = [
        'gen' => 'jan',
        'feb' => 'feb',
        'mar' => 'mar',
        'apr' => 'apr',
        'mag' => 'may',
        'giu' => 'jun',
        'lug' => 'jul',
        'ago' => 'aug',
        'set' => 'sep',
        'ott' => 'oct',
        'nov' => 'nov',
        'dic' => 'dec',
    ];
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($date)
    {

       // Imposta la lingua italiana per Carbon
        App::setLocale('it');

        // Crea una nuova istanza di DateTime utilizzando il formato italiano
        $parsedDate = DateTime::createFromFormat('D d F Y', $date);

        // Crea una nuova istanza di Carbon dalla data analizzata
        $carbonDate = Carbon::instance($parsedDate);

        // Formatta la data nel formato desiderato: "31/08/2023"
        $formattedDate = $carbonDate->format('d/m/Y');
        $reservationDate = ReservationDate::where('data', $formattedDate)->first();

        if ($reservationDate) {
            // La data esiste, quindi visualizza la pagina "show"
            return Inertia::render('Dashboard/Date/Show', [
                'data' => $reservationDate
            ]);
        } else {
            // La data non esiste, quindi visualizza la pagina "create"
            return Inertia::render('Dashboard/Date/Create', [
                // Dati da passare al template
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
