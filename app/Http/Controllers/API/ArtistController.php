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
            // $artists = Artist::all();

            return response()->json([
                'message' => 'Artista inserito correttamente',
                'class' => 'alert-success'
        ]);
        } else {
            return response()->json('Qualcosa è andato storto');
        }
    }

    protected function getArtistByType($show_type_id){
        $filteredArtistByType = Artist::with('showType')->where('show_type_id', $show_type_id)->get();

        return response()->json(['artistiFiltrati' => $filteredArtistByType]);
    }

    protected function getArtistTitoloByType($show_type_id){
        $filteredArtistByType = Artist::where('show_type_id', $show_type_id)->get(['id', 'titolo']);

        return response()->json(['artistiFiltrati' => $filteredArtistByType]);
    }
}
