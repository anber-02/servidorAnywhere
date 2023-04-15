<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hoteles;
use App\Models\Imagen;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
class HotelController extends Controller
{
    //
    public function getHoteles(){
        // Obtiene cada tienda con sus comentario e imagenes
        // $tiendas = Tiendas::with('imagenes', 'comentarios')->paginate(4);
        // $hoteles = Hoteles::with('imagenes')->paginate(4);
        $hoteles = Hoteles::with('comentarios')->paginate(4);
        return response()->json($hoteles, 200);
    }

    public function getHotelById($id){
        $hotel = Hoteles::find($id);
        $imagenes = $hotel->imagenes;
        $comentarios = $hotel->comentarios;
        return response()->json([
            'restaurante' => $hotel
        ],200);
    }


    public function saveHotel(Request $request){
        // $request->headers->set('Content-Type', 'multipart/form-data');
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required | string | max:255',
            'direccion' => 'required | string | max:255',
            'contacto_tel' => 'required | string | min:10',
            'contacto_correo' => 'required | string | email | unique:tiendas',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $hotel = Hoteles::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'contacto_tel' => $request->contacto_tel,
            'contacto_correo' => $request->contacto_correo,
        ]);
        
        $images = array();
        if($request->hasFile('imagen')){

            $files = $request->file('imagen');
            $url = "";
            foreach($files as $file){
                $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'anywhere/hoteles']);
                $url = $obj->getSecurePath();
                $public_id = $obj->getPublicId();
                $tipo = $obj->getFileType();
                $nombre = $obj->getOriginalFileName();
                $images[] = Imagen::create([
                    'tipo' => $tipo,
                    'nombre' => $nombre,
                    'public_id' => $public_id,
                    'url' => $url,
                    'tiendas_id' => $hotel->idTiendas
                ]);
            }
            $hotel->imagenes = $images;
        }
        return response()->json([
            "data" => $hotel,
        ], 201);
    }
}
