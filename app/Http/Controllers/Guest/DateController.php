<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\ReservationDate;
use App\Models\ShowType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;

class DateController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMare($data)
    {
        // Imposta la lingua italiana per Carbon
        App::setLocale('it');

        $matchedData = ReservationDate::with('showType')
        ->with('bookings')
        ->where('data', $data)
        ->get();

        return Inertia::render('Guest/Mare/Show', [
            'data' => $matchedData,
        ]);
    }

    public function noDate($data){

        return Inertia::render('Guest/NoDate',[
            'data' => $data
        ]);
    }
}
