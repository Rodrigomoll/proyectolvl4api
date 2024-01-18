<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Iniciar sesión (Login)
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['usuario' => $request->usuario, 'password' => $request->password])) {
            throw ValidationException::withMessages([
                'usuario' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $token = $request->user()->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Obtener información del usuario autenticado
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        // Verificar si hay un usuario autenticado
        $user = $request->user();

        if ($user) {
            $userId = $user->id;
            $usuario = Usuarios::find($userId);

            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            return response()->json($usuario, 200);
        }

        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }


    public function getUserInfoByUsername(Request $request, $usuario)
    {
        // Verificar si hay un usuario autenticado
        $user = $request->user();

        if ($user) {
            $usuario = Usuarios::where('usuario', $usuario)->first();

            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            return response()->json($usuario, 200);
        }

        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    public function updateUsuarioInfo(Request $request, $usuario)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    $request->validate([
        'primerNombre' => 'required',
        'segundoNombre' => 'nullable',
        'primerApellido' => 'required',
        'segundoApellido' => 'nullable',
        'usuario' => 'required',
        'password' => 'required',
    ]);

    // Actualizar la información del usuario
    $usuario = Usuarios::where('usuario', $usuario)->first();

    if (!$usuario) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    $usuario->primerNombre = $request->primerNombre;
    $usuario->segundoNombre = $request->segundoNombre;
    $usuario->primerApellido = $request->primerApellido;
    $usuario->segundoApellido = $request->segundoApellido;
    $usuario->usuario = $request->usuario;
    $usuario->password = Hash::make($request->password); // Recuerda siempre hashear la contraseña antes de guardarla

    $usuario->save();

    return response()->json(['message' => 'Información del usuario actualizada correctamente'], 200);
}

    public function updateUserInfo(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $request->validate([
            'primerNombre' => 'required',
            'segundoNombre' => 'nullable',
            'primerApellido' => 'required',
            'segundoApellido' => 'nullable',
            'usuario' => 'required',
            'password' => 'required',
        ]);

        // Actualizar la información del usuario
        $user->primerNombre = $request->primerNombre;
        $user->segundoNombre = $request->segundoNombre;
        $user->primerApellido = $request->primerApellido;
        $user->segundoApellido = $request->segundoApellido;
        $user->usuario = $request->usuario;
        $user->password = Hash::make($request->password); // Recuerda siempre hashear la contraseña antes de guardarla

        $user->save();

        return response()->json(['message' => 'Información del usuario actualizada correctamente'], 200);
    }


    /**
     * Cerrar sesión (Logout)
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
