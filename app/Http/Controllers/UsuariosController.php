<?php

namespace App\Http\Controllers;

use App\Events\BitacoraRegistrada;
use App\Models\Roles;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios, 200);
    }

    public function show($id)
    {
        $usuario = Usuarios::find($id);

        if(!$usuario){
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'primerNombre' => 'required',
            'primerApellido' => 'required',
            'usuario' => 'required|unique:usuarios',
            'password' => 'required',
            'idRol' => 'required|exists:roles,id',
        ]);

        $rol = Roles::find($request->input('idRol'));

        $usuario = Usuarios::create([
            'primerNombre' => $request->input('primerNombre'),
            'segundoNombre' => $request->input('segundoNombre'),
            'primerApellido' => $request->input('primerApellido'),
            'segundoApellido' => $request->input('segundoApellido'),
            'usuario' => $request->input('usuario'),
            'password' => Hash::make($request->input('password')),
            'estado' => $request->input('estado', true),
            'idRol' => $rol->id,
        ]);

        // Evento para la creación de un nuevo usuario
        event(new BitacoraRegistrada("Se creó un usuario con ID: {$usuario->id}", 'crear_usuario'));

        return response()->json(['message' => 'Un usuario ha sido creado'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuarios $usuarios)
    {
        $request->validate([
            'primerNombre' => 'required',
            'primerApellido' => 'required',
            'usuario' => 'required|unique:usuarios,usuario,' . $usuarios->id,
            'password' => 'required',
            'idRol' => 'required|exists:roles,id',
        ]);

        $rol = Roles::find($request->input('idRol'));

        $usuarios->update([
            'primerNombre' => $request->input('primerNombre'),
            'segundoNombre' => $request->input('segundoNombre'),
            'primerApellido' => $request->input('primerApellido'),
            'segundoApellido' => $request->input('segundoApellido'),
            'usuario' => $request->input('usuario'),
            'password' => Hash::make($request->input('password')),
            'estado' => $request->input('estado', true),
            'idRol' => $rol->id,
        ]);

        // Evento para la actualización de un usuario
        event(new BitacoraRegistrada("Se actualizó el usuario con ID: {$usuarios->id}", 'actualizar_usuario'));

        return response()->json(['message' => 'Un usuario ha sido actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuarios $usuarios)
    {
        $usuarios->delete();

        // Evento para la eliminación de un usuario
        event(new BitacoraRegistrada("Se eliminó el usuario con ID: {$usuarios->id}", 'eliminar_usuario'));

        return response()->json(['message' => 'Un usuario ha sido eliminado']);
    }
}
