<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurantes;
use App\Models\Imagen;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;


class RestauranteController extends Controller
{
    //
    public function getRestaurantes(){
        // Obtiene cada tienda con sus comentario e imagenes
        // $restaurantes = Restaurantes::with('imagenes', 'comentarios')->paginate(4);
        $restaurantes = Restaurantes::with('imagenes')->paginate(10);
        // $restaurantes = Restaurantes::with('comentarios')->paginate(4);
        return response()->json($restaurantes, 200);
    }

    public function getRestauranteById($id){
        $restaurante = Restaurantes::find($id);
        if(is_null($restaurante)){
            return response()->json(['mensaje' => 'restaurante no encontrado'], 404);
        }
        $imagenes = $restaurante->imagenes;
        $comentarios = $restaurante->comentarios()->with('users')
        ->get();


        $restaurante->comentarios = $comentarios;


        return response()->json([
            'data' => $restaurante
        ],200);
    }


    public function saveRestaurante(Request $request){
        // $request->headers->set('Content-Type', 'multipart/form-data');
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required | string | max:255',
            'direccion' => 'required | string | max:255',
            'contacto_tel' => 'required | string',
            'contacto_correo' => 'required | string | email | unique:restaurantes',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $restaurante = Restaurantes::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'contacto_tel' => $request->contacto_tel,
            'contacto_correo' => $request->contacto_correo,
        ]);
        
        if($request->hasFile('imagen')){
            $files = $request->file('imagen');
            $url = "";
            foreach($files as $file){
                $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'anywhere/restaurantes']);
                $url = $obj->getSecurePath();
                $public_id = $obj->getPublicId();
                $tipo = $obj->getFileType();
                $nombre = $obj->getOriginalFileName();


                // $images[] = Imagen::create([
                //     'tipo' => $tipo,
                //     'nombre' => $nombre,
                //     'public_id' => $public_id,
                //     'url' => $url,
                //     'tiendas_id' => $restaurante->idTiendas
                // ]);

                // Prueba de guardar imagenes
                $imagen = Imagen::create([
                    'tipo' => $tipo,
                    'nombre' => $nombre,
                    'public_id' => $public_id,
                    'url' => $url,
                ]);


                $restaurante->imagenes()->attach($imagen->id);
                // if ($request->hasFile('imagenes')) {
                //     foreach ($request->file('imagenes') as $imagen) {
                //         $path = $imagen->store('public/imagenes');
                //         $url = Storage::url($path);
        
                //         $imagen = new Imagen;
                //         $imagen->url = $url;
                //         $imagen->save();
        
                //         $producto->imagenes()->attach($imagen->id, ['principal' => false]);
                //     }
        
                //     // Asociar la primera imagen como principal
                //     $producto->imagenes()->first()->pivot->principal = true;
                //     $producto->imagenes()->first()->pivot->save();
                // }
            }
            $restaurante->imagenes;
        }
        return response()->json([
            "data" => $restaurante,
        ], 201);
    }

    public function updateRestaurante(Request $request, $id){
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required | string | max:255',
            'direccion' => 'required | string | max:255',
            'contacto_tel' => 'required | string | min:10',
            // 'contacto_correo' => 'required | string | email | unique:tiendas',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $restaurante = Restaurantes::findOrFail($id);
        $imagenes = $restaurante->imagenes()->get();
        $restaurante->update([
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
        
                $restaurante->imagenes()->attach($imagen->id);
            }
            // Asociar la primera imagen como principal
            // $producto->imagenes()->first()->pivot->principal = true;
            // $producto->imagenes()->first()->pivot->save();
        }
        // $imagenesDesasociadas = $imagenes->diff($tienda->imagenes());
        // foreach ($imagenesDesasociadas as $imagen) {
        //     $imagen->delete();
        // }

        $restaurante->imagenes;
        return response()->json([
            "data" => $restaurante,
        ], 201);
    }

    public function deleteRestaurante($id){
        $restaurante = Restaurantes::find($id);
        if(is_null($restaurante)){
            return response()->json(['mensaje' => 'restaurante no encontrado'], 404);
        }
        $restaurante->delete();
        return response( ['Producto eliminado'], 203);
    }
}
