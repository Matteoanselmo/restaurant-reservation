<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShowType;

class ShowTypeController extends Controller
{
    public function index()
    {
        $showTypes = ShowType::all();

        return response()->json($showTypes);
    }
}
