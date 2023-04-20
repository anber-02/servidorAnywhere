<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use App\Models\Hoteles;
use App\Models\Restaurantes;
use App\Models\Tiendas;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    //
    public function createComement(Request $request){

        // return response()->json([
        //     "comentario" => $request->all()
        // ], 201);

        $comentario = Comentarios::create([
            "comentario" => $request->comentario, 
            "usuarios_idUsuarios" =>$request->idUser
        ]);

        if($request->idHotel){
            $hotel = Hoteles::find($request->idHotel);
            $hotel->comentarios()->attach($comentario->idComen);
        }
        if($request->idTienda){
            $tienda = Tiendas::find($request->idTienda);
            $tienda->comentarios()->attach($comentario->idComen);

        }
        if($request->idRestaurante){
            $restaurante = Restaurantes::find($request->idRestaurante);
            $restaurante->comentarios()->attach($comentario->idComen);
        }



        $usuario = User::find($request->idUser);
        $usuario->comentarios()->save($comentario);

        $comentario->users;

        return response()->json([
            "comentario" => $comentario
        ], 201);
    }
}
