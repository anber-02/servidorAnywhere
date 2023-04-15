<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Tiendas;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;


class TiendaController extends Controller
{
    //

    public function getTiendas(){
        // Obtiene cada tienda con sus comentario e imagenes
        // $tiendas = Tiendas::with('imagenes', 'comentarios')->paginate(4);
        $tiendas = Tiendas::with('imagenes')->paginate(4);
        return response()->json($tiendas, 200);
    }

    public function getTiendaById($id){
        $tienda = Tiendas::find($id);
        $imagenes = $tienda->imagenes;
        $comentarios = $tienda->comentarios;
        return response()->json([
            'tienda' => $tienda
        ],200);
    }


    public function saveTienda(Request $request){
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
        $tienda = Tiendas::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'contacto_tel' => $request->contacto_tel,
            'contacto_correo' => $request->contacto_correo,
        ]);
        
        if($request->hasFile('imagen')){

            $files = $request->file('imagen');
            $url = "";
            foreach($files as $file){
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


                $tienda->imagenes()->attach($imagen->id);
            }
            $tienda->imagenes;
        }
        return response()->json([
            "data" => $tienda,
        ], 201);
    }

    public function updateTienda(Request $request, $id){
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required | string | max:255',
            'direccion' => 'required | string | max:255',
            'contacto_tel' => 'required | string | min:10',
            'contacto_correo' => 'required | string | email | unique:tiendas',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        

        $tienda = Tiendas::find($id);
        $tienda->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'contacto_tel' => $request->contacto_tel,
            'contacto_correo' => $request->contacto_correo,
        ]);
        // imagen a actualizar
        
        if($request->hasFile('imagen')){
            $imagen = Imagen::find($request->id);
            Cloudinary::destroy($imagen->public_id);
            $file = $request->file('imagen');
            $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'anywhere/tiendas']);
            $url = $obj->getSecurePath();
            $public_id = $obj->getPublicId();
            $tipo = $obj->getFileType();
            $nombre = $obj->getOriginalFileName();
            $imagen->update([
                'tipo' => $tipo,
                'nombre' => $nombre,
                'public_id' => $public_id,
                'url' => $url,
                'tiendas_id' => $tienda->idTiendas
            ]);
            $tienda->imagenes = $imagen;
        }
        return response()->json([
            "data" => $tienda,
        ], 201);
    }
}
