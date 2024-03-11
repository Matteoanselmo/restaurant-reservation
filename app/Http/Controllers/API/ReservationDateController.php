<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\ReservationDate;
use App\Models\ReservationDateImage;
use App\Models\ShowType;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReservationDateController extends Controller {
    protected function index($month, $showTypeId) {
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

    public function show($data) {
        // Imposta la lingua italiana per Carbon

        $matchedData = ReservationDate::where('data', $data)->with(['images', 'artists'])->get();
        $showTypes = ShowType::all();
        return response()->json([
            'data' => $matchedData,
            'showTypes' => $showTypes
        ]);
    }

    protected function allMonthDate($month) {
        $reservationDates = ReservationDate::with('showType')
            ->where(DB::raw('MONTH(data)'), '=', $month)
            ->get();

        if ($reservationDates->isEmpty()) {
            return response()->json(false);
        }

        return response()->json($reservationDates);
    }

    public function store(Request $request) {
        $request->validate([
            'data' => 'date',
            // 'show_type_id' => 'required|exists:show_types.id',
            'titolo' => 'required|string',
            'descrizione' => 'required|string',
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
                $imageExt = $image->getClientOriginalExtension();
                $timestamp = time();
                $imageName = $timestamp . '.' . $imageExt;
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

    protected function updatereservationDate(Request $request) {
        $request->validate([
            'data' => 'date',
            'titolo' => 'string',
            'descrizione' => 'string',
            'pranzo_cena' => 'in:pranzo,cena',
            // 'img.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Valida le immagini
        ]);

        $reservationDate = ReservationDate::find($request->id);

        if (!$reservationDate) {
            return response()->json('Record non trovato');
        }

        $data = $request->all();

        $reservationDate->update([
            'data' => $data['data'],
            'show_type_id' => $data['show_type_id'],
            'titolo' => $data['titolo'],
            'descrizione' => $data['descrizione'],
            'prezzo' => $data['prezzo'],
            'pranzo_cena' => $data['pranzo_cena'],
        ]);


        $artistiInput = json_decode($data['artisti'], true);

        // Ottieni gli id degli artisti esistenti per questa reservation date
        $artistiEsistenti = $reservationDate->artists()->pluck('artists.id')->toArray();

        // // Trova gli id da rimuovere (artisti non più selezionati)
        $idDaRimuovere = array_diff($artistiEsistenti, array_column($artistiInput, 'id'));

        // // Trova gli id da aggiungere (nuovi artisti selezionati)
        $idDaAggiungere = array_diff(array_column($artistiInput, 'id'), $artistiEsistenti);

        // // Rimuovi gli artisti non più selezionati
        if (!empty($idDaRimuovere)) {
            $reservationDate->artists()->detach($idDaRimuovere);
        }

        // // Aggiungi gli artisti selezionati
        if (!empty($idDaAggiungere)) {
            $reservationDate->artists()->attach($idDaAggiungere);
        }

        // Gestisci le immagini
        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $image) {
                $imageExt = $image->getClientOriginalExtension();
                $timestamp = time();
                $imageName = $timestamp . '.' . $imageExt;
                $imagePath = '/uploads/' . $imageName;

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

        return response()->json($artistiInput);
    }

    protected function deleteReservationDateImg($id) {
        $image = ReservationDateImage::findOrFail($id);
        if (file_exists($image->path)) {
            unlink($image->path); // Elimina il file fisico
        }

        $image->delete();

        return response()->json([
            'message' => 'foto eliminata correttamente',
            'class' => 'alert-succcess'
        ]);
    }

    public function destroy($id) {
        $reservationDate = ReservationDate::findOrFail($id);
        $data = $reservationDate->data;

        // Ottieni le immagini associate alla data di prenotazione
        $images = ReservationDateImage::where('reservation_date_id', $reservationDate->id)->get();

        // Elimina le immagini dalla cartella public/uploads/
        foreach ($images as $image) {
            $imagePath = $image->path;
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

    protected function deleteBooked($id) {
        $booked = Booking::where('id', $id)->first();
        $booked->delete();
        //$reservationDate = ReservationDate::where('id', $request->reservationId)->select('id','titolo','data', 'pranzo_cena');
        //return response()->json($reservationDate);
        //return Inertia::render('Dashboard/Prenotazioni/PrenotazioneShow', ['prenotazione' => $reservationDate]);
        // $booked->delete();

        return true;
    }
}
