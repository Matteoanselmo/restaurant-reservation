<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArtistiController extends Controller
{
    protected function index(){
        $artists = Artist::with('showType')->get();

        return Inertia::render('Dashboard/Artisti/Artisti', [
            'artisti' => $artists
        ]);
    }

    protected function create(){
        return Inertia::render('Dashboard/Artisti/Create');
    }
}
