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
        Artist::create([
            'titolo' => $request->title,
            'descrizione' => $request->description,
            'show_type_id' => $request->show_type_id
        ]);

        $artists = Artist::all();

        return redirect()->route('dashboard.artists.index', compact('artists'))->with('message', 'Artista-inserito correttamente');

        // return Inertia::render('Dashboard/Artisti/Artisti', [
        //     'message' => 'Artista inserito correttamente',
        //     'artisti' => Artist::all()
        // ]);
    }
}
