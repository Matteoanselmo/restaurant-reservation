<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationDate;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReservationDateController extends Controller
{
    public function index($month, $showTypeId)
    {
        $reservationDates = ReservationDate::with('showType')
            ->with('bookings')
            ->where(DB::raw('MONTH(data)'), '=', $month)
            ->where('show_type_id', $showTypeId)
            ->get();

        if ($reservationDates->isEmpty()) {
            return response()->json(false);
        }

        return response()->json($reservationDates);
    }

    public function allMonthDate($month)
    {
        $reservationDates = ReservationDate::with('showType')
            ->where(DB::raw('MONTH(data)'), '=', $month)
            ->get();

        if ($reservationDates->isEmpty()) {
            return response()->json(false);
        }

        return response()->json($reservationDates);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'date',
            // 'show_type_id' => 'required|exists:show_types.id',
            'titolo' => 'string',
            'descrizione' => 'string',
            // 'prezzo' => 'float',
            'pranzo_cena' => 'in:pranzo,cena', // Aggiunto il controllo per pranzo o cena
        ]);

        ReservationDate::create([
            'data' => $request->_value['data'],
            'show_type_id' => $request->_value['show_type_id'],
            'titolo' => $request->_value['titolo'],
            'descrizione' => $request->_value['descrizione'],
            'prezzo' => $request->_value['prezzo'],
            'pranzo_cena' => $request->_value['pranzo_cena'],
        ]);

        return redirect()->route('dashboard.date.index');
    }

    public function destroy($id){
        $reservationDates = ReservationDate::findOrFail($id);

        $existOther = ReservationDate::where('data', $reservationDates->data)
        ->whereNotIn('id', [$reservationDates->id])
        ->get();

        if(count($existOther) > 0){
            $reservationDates->delete();
            $date = ReservationDate::where('data', $reservationDates->data)->get();
            // return response()->json([
            //     "data" => $date
            // ]);
            return Inertia::render('Dashboard/Date/Index');
        } else {
            $reservationDates->delete();

            return redirect()->route('dashboard.date.index');
            //return response()->json($id);
        }
    }
}


