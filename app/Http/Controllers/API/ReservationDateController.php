<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationDate;
use App\Models\ReservationDateImage;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReservationDateController extends Controller
{
    protected function index($month, $showTypeId)
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

    protected function allMonthDate($month)
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

        $reservationDate = ReservationDate::create([
            'data' => $request['data'],
            'show_type_id' => $request['show_type_id'],
            'titolo' => $request['titolo'],
            'descrizione' => $request['descrizione'],
            'prezzo' => $request['prezzo'],
            'pranzo_cena' => $request['pranzo_cena'],
        ]);

        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $image) {
                $imageName = $image->getClientOriginalName();
                $imageExt = $image->getClientOriginalExtension();
                $imagePath = $image->move(public_path('images'), $imageName); // Salva l'immagine nella directory "public/images"

                ReservationDateImage::create([
                    'name' => $imageName,
                    'ext' => $imageExt,
                    'path' => $imagePath,
                    'reservation_date_id' => $reservationDate->id,
                ]);
            }
        }

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


