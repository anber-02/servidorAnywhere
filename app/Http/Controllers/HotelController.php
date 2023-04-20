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
        $hoteles = Hoteles::with('imagenes')->paginate(10);
        // $hoteles = Hoteles::with('comentarios')->paginate(4);
        return response()->json($hoteles, 200);
    }

    public function getHotelById($id){
        $hotel = Hoteles::find($id);
        if(is_null($hotel)){
            return response()->json(['mensaje' => 'hotel no encontrado'], 404);
        }
        $imagenes = $hotel->imagenes;
        $comentarios = $hotel->comentarios()->with('users')
        ->get();


        $hotel->comentarios = $comentarios;

        return response()->json([
            'data' => $hotel
        ],200);
    }


    public function saveHotel(Request $request){
        // $request->headers->set('Content-Type', 'multipart/form-data');
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required | string | max:255',
            'direccion' => 'required | string | max:255',
            'contacto_tel' => 'required | string',
            'contacto_correo' => 'required | string | email | unique:hoteles',
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

        if($request->hasFile('imagen')){

            $files = $request->file('imagen');
            $url = "";
            foreach($files as $file){
                $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'anywhere/hoteles']);
                $url = $obj->getSecurePath();
                $public_id = $obj->getPublicId();
                $tipo = $obj->getFileType();
                $nombre = $obj->getOriginalFileName();
                $imagen = Imagen::create([
                    'tipo' => $tipo,
                    'nombre' => $nombre,
                    'public_id' => $public_id,
                    'url' => $url,
                ]);


                $hotel->imagenes()->attach($imagen->id);
            }
            $hotel->imagenes;
        }
        return response()->json([
            "data" => $hotel,
        ], 201);
    }


    public function updateHotel(Request $request, $id){
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required | string | max:255',
            'direccion' => 'required | string | max:255',
            'contacto_tel' => 'required | string | min:10',
            // 'contacto_correo' => 'required | string | email | unique:tiendas',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $hotel = Hoteles::findOrFail($id);
        $imagenes = $hotel->imagenes()->get();
        $hotel->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'contacto_tel' => $request->contacto_tel,
            'contacto_correo' => $request->contacto_correo,
        ]);
        // imagen a actualizar

        if ($request->hasFile('imagen')) {
            $files = $request->file('imagen');
            foreach ($files as $file) {
                $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'anywhere/tiendas']);
                $url = $obj->getSecurePath();
                $public_id = $obj->getPublicId();
                $tipo = $obj->getFileType();
                $nombre = $obj->getOriginalFileName();

                $imagen = Imagen::create([
                    'tipo' => $tipo,
                    'nombre' => $nombre,
                    'public_id' => $public_id,
                    'url' => $url,
                ]);
        
                $hotel->imagenes()->attach($imagen->id);
            }
            // Asociar la primera imagen como principal
            // $producto->imagenes()->first()->pivot->principal = true;
            // $producto->imagenes()->first()->pivot->save();
        }
        // $imagenesDesasociadas = $imagenes->diff($tienda->imagenes());
        // foreach ($imagenesDesasociadas as $imagen) {
        //     $imagen->delete();
        // }

        $hotel->imagenes;
        return response()->json([
            "data" => $hotel,
        ], 201);
    }
    public function deleteHotel($id){
        $hotel = Hoteles::find($id);
        if(is_null($hotel)){
            return response()->json(['mensaje' => 'hotel no encontrado'], 404);
        }
        $hotel->delete();
        return response( ['Producto eliminado'], 203);
    }

}
