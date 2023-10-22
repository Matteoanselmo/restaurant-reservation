<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShowType;

class ShowTypeController extends Controller
{
    protected function index()
    {
        $showTypes = ShowType::all();

        return response()->json($showTypes);
    }
}
