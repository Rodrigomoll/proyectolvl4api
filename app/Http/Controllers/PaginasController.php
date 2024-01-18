<?php

namespace App\Http\Controllers;

use App\Events\BitacoraRegistrada;
use App\Models\Paginas;
use Illuminate\Http\Request;

class PaginasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Paginas::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $this->validate($request, [
            'url' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $pagina = new Paginas();
        $pagina->url = $request->url;
        $pagina->nombre = $request->nombre;
        $pagina->descripcion = $request->descripcion;
        $pagina->save();

        // Evento para la creación de una nueva página
        event(new BitacoraRegistrada("Se creó una página con ID: {$pagina->id}", 'crear_pagina'));

        return response()->json(['message' => 'Una página ha sido creada'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos
        $this->validate($request, [
            'url' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $pagina = Paginas::find($id);
        $pagina->url = $request->url;
        $pagina->nombre = $request->nombre;
        $pagina->descripcion = $request->descripcion;
        $pagina->save();

        // Evento para la actualización de una página
        event(new BitacoraRegistrada("Se actualizó la página con ID: {$pagina->id}", 'actualizar_pagina'));

        return response()->json(['message' => 'Una página ha sido actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pagina = Paginas::find($id);
        $pagina->delete();

        // Evento para la eliminación de una página
        event(new BitacoraRegistrada("Se eliminó la página con ID: {$pagina->id}", 'eliminar_pagina'));

        return response()->json(['message' => 'Una página ha sido eliminada']);
    }
}
