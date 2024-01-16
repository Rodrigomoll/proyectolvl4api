<?php

namespace App\Http\Controllers;

use App\Events\BitacoraRegistrada;
use App\Models\Paginas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaginasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginas = Paginas::all();
        return response()->json($paginas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $pagina = Paginas::create([
            'url' => $request->input('url'),
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        // Evento para la creación de una nueva página
        event(new BitacoraRegistrada("Se creó una página con ID: {$pagina->id}", 'crear_pagina'));

        return response()->json(['message' => 'Una página ha sido creada'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paginas $paginas)
    {
        return response()->json($paginas, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paginas $paginas)
    {
        $request->validate([
            'url' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $paginas->update([
            'url' => $request->input('url'),
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        // Evento para la actualización de una página
        event(new BitacoraRegistrada("Se actualizó la página con ID: {$paginas->id}", 'actualizar_pagina'));

        return response()->json(['message' => 'Una página ha sido actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paginas $paginas)
    {
        $paginas->delete();

        // Evento para la eliminación de una página
        event(new BitacoraRegistrada("Se eliminó la página con ID: {$paginas->id}", 'eliminar_pagina'));

        return response()->json(['message' => 'Una página ha sido eliminada']);
    }
}
