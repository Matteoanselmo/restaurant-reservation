<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\ArtistiController;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtistController extends Controller
{
    protected function store(Request $request){

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'show_type_id' => 'required|integer',
        ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Crea un nome univoco per l'immagine
            $imagePath = $image->move(public_path('images'), $imageName); // Salva l'immagine nella directory "public/images"

            // Crea un nuovo artista con i dati del modulo e i dati relativi all'immagine
            $artist = new Artist;
            $artist->titolo = $request->input('title');
            $artist->descrizione = $request->input('description');
            $artist->show_type_id = $request->input('show_type_id');
            $artist->img_name = $imageName;
            $artist->img_path = 'images/' . $imageName; // Percorso pubblico all'immagine
            $artist->img_ext = $image->getClientOriginalExtension();
            $artist->save();
            $artists = Artist::all();

            return redirect()->route('dashboard.artists.index', compact('artists'))->with('message', 'Artista-inserito correttamente');
        } else {
            return response()->json('Qualcosa è andato storto');
        }



        // return Inertia::render('Dashboard/Artisti/Artisti', [
        //     'message' => 'Artista inserito correttamente',
        //     'artisti' => Artist::all()
        // ]);
    }
}
