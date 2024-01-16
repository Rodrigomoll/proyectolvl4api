<?php

namespace App\Http\Controllers;

use App\Models\Bitacoras;
use Illuminate\Http\Request;

class BitacorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bitacoras = Bitacoras::all();
        return response()->json($bitacoras, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bitacoras $bitacoras)
    {
        return response()->json($bitacoras, 200);
    }
}
