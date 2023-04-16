<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class, 'register']);
Route::post('auth', [AuthController::class, 'auth']);
// proteger las rutas con el middleware
Route::middleware('jwt.verify')->group(function (){
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::get('users', [UserController::class, 'getUsers']);
});


// RUTAS DE TIENDAS
Route::post('nuevaTienda', [TiendaController::class, 'saveTienda']);
Route::get('tiendas', [TiendaController::class, 'getTiendas']);
Route::get('tienda/{id}', [TiendaController::class, 'getTiendaById']);
Route::put('tienda/{id}', [TiendaController::class, 'updateTienda']);
// RUTAS DE HOOTELES
Route::post('nuevoHotel', [HotelController::class, 'saveHotel']);
Route::get('hoteles', [HotelController::class, 'getHoteles']);
Route::get('hotel/{id}', [HotelController::class, 'getHotelById']);
Route::put('hote;/{id}', [HotelController::class, 'updateHotel']);
// RUTAS DE RESTAURANTEs
Route::post('nuevoRestaurante', [RestauranteController::class, 'saveRestaurante']);
Route::get('restaurantes', [RestauranteController::class, 'getRestaurantes']);
Route::get('restaurante/{id}', [RestauranteController::class, 'getRestauranteById']);
Route::put('restaurante/{id}', [RestauranteController::class, 'updateRestaurante']);

//RUTA DE IMAGENES
Route::delete('imagen/{id}', [ImagenController::class, 'deleteImagen']);
