<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationDate;
use Illuminate\Support\Facades\DB;

class ReservationDateController extends Controller
{
    public function index($month)
{
    $reservationDates = ReservationDate::where(DB::raw('MONTH(data)'), '=', $month)->get();

    if ($reservationDates->isEmpty()) {
        return response()->json(false);
    }

    return response()->json($reservationDates);
}



    public function store(Request $request)
    {
        // $request->validate([
        //     'data' => 'required|date',
        //     'show_type_id' => 'required|exists:show_types,id',
        //     'titolo' => 'required|string',
        //     'descrizione' => 'required|string',
        //     'posti_disponibili' => 'required|integer|min:1|max:8',
        //     'pranzo_cena' => 'required|in:pranzo,cena', // Aggiunto il controllo per pranzo o cena
        // ]);

        // ReservationDate::create([
        //     'data' => $request->_value['data'],
        //     'show_type_id' => $request->_value['show_type_id'],
        //     'titolo' => $request->_value['titolo'],
        //     'descrizione' => $request->_value['descrizione'],
        //     'posti_disponibili' => $request->_value['posti_disponibili'],
        //     'pranzo_cena' => $request->_value['pranzo_cena'],
        // ]);

        // return redirect()->route('dashboard.date.index');
        return response()->json($request->_value['show_type_id']);
    }
}


