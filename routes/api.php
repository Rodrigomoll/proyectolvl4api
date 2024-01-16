<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BitacorasController;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[AuthController::class, 'login']);
Route::post('logout',[AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('getUserInfo', [AuthController::class, 'getUserInfo']);
Route::middleware('auth:sanctum')->post('updateUserInfo', [AuthController::class, 'updateUserInfo']);

Route::get('roles',[RolesController::class, 'index']);
Route::post('roles',[RolesController::class, 'store']);
Route::put('roles/{id}',[RolesController::class, 'put']);
Route::delete('roles/{id}',[RolesController::class, 'destroy']);

// Rutas para Usuarios
Route::get('usuarios', [UsuariosController::class, 'index']);
Route::get('usuarios/{id}', [UsuariosController::class, 'show']);
Route::post('usuarios', [UsuariosController::class, 'store']);
Route::put('usuarios/{id}', [UsuariosController::class, 'update']);
Route::delete('usuarios/{id}', [UsuariosController::class, 'destroy']);

// Rutas para Bitacoras
Route::get('bitacoras', [BitacorasController::class, 'index']);
Route::post('bitacoras', [BitacorasController::class, 'store']);
Route::put('bitacoras/{id}', [BitacorasController::class, 'update']);
Route::delete('bitacoras/{id}', [BitacorasController::class, 'destroy']);

// Rutas para Páginas
Route::get('paginas', [PaginasController::class, 'index']);
Route::post('paginas', [PaginasController::class, 'store']);
Route::put('paginas/{id}', [PaginasController::class, 'update']);
Route::delete('paginas/{id}', [PaginasController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
