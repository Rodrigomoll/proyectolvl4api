<?php

namespace App\Http\Controllers;

use App\Events\BitacoraRegistrada;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Roles::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $this->validate($request, [
            'rol' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        $rol = new Roles();
        $rol->rol = $request->rol;
        $rol->estado = $request->estado;
        $rol->save();

        // Evento para la creación de un nuevo rol
        event(new BitacoraRegistrada("Se creó un rol con ID: {$rol->id}", 'crear_rol'));

        return response()->json(['message' => 'Un rol ha sido agregado'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos
        $this->validate($request, [
            'rol' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        $rol = Roles::find($id);
        $rol->rol = $request->rol;
        $rol->estado = $request->estado;
        $rol->save();

        // Evento para la actualización de un rol
        event(new BitacoraRegistrada("Se actualizó el rol con ID: {$rol->id}", 'actualizar_rol'));

        return response()->json(['message' => 'Un rol ha sido actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rol = Roles::find($id);
        $rol->delete();

        // Evento para la eliminación de un rol
        event(new BitacoraRegistrada("Se eliminó el rol con ID: {$rol->id}", 'eliminar_rol'));

        return response()->json(['message' => 'Un rol ha sido eliminado']);
    }
}
