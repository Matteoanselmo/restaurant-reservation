<?php

namespace App\Http\Controllers\Api;

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

        if ($request->has('artisti')) {
            $artistIds = explode(',', $request['artisti']);
            $reservationDate->artists()->attach($artistIds);
        }



        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $image) {
                $imageName = $image->getClientOriginalName();
                $imageExt = $image->getClientOriginalExtension();
                $imagePath = '/uploads/' . $imageName; // Percorso relativo

                // Salva l'immagine nella directory "public/uploads"
                $image->move(public_path('uploads'), $imageName);

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

    public function destroy($id) {
        $reservationDate = ReservationDate::findOrFail($id);
        $data = $reservationDate->data;

        // Ottieni le immagini associate alla data di prenotazione
        $images = ReservationDateImage::where('reservation_date_id', $reservationDate->id)->get();

        // Elimina le immagini dalla cartella public/images/
        foreach ($images as $image) {
            $imagePath = public_path('images/' . $image->path);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Elimina il file fisico
            }
        }

        // Elimina la data di prenotazione
        $reservationDate->delete();

        // Verifica se ci sono altre date con la stessa data
        $otherDates = ReservationDate::where('data', $data)
            ->where('id', '<>', $reservationDate->id)
            ->count();

        if ($otherDates > 0) {
            return redirect()->route('dashboard.date.show', $data);
        } else {
            return redirect()->route('dashboard.date.index');
        }
    }

}


