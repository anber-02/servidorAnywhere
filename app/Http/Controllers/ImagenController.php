<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImagenController extends Controller
{
    //
    public function deleteImagen($id){
        Cloudinary::destroy(Imagen::find($id)->public_id);
        Imagen::destroy($id);
        return response()->json([
            "msg" => "Imagen eliminada correctamente"
        ], 204);
    }

    public function updateImage(){

    }
}
