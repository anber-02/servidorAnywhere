<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        // $request->headers->set('Content-Type', 'multipart/form-data');
        $validator = Validator::make($request -> all(), [
            'name' => 'required | string | max:255',
            'email' => 'required | string | email | unique:users',
            'password' => 'required | string | min:8',
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'anywhere/users']);
            $url = $obj->getSecurePath();
            $public_id = $obj->getPublicId();

            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'num_tel' => $request->num_tel,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'url_image' => $url,
                'public_id' => $public_id,
                'tipo' => $request->tipo
            ]);
            return response()->json(['user' => $user], 201);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'last_name' => $request->last_name,
            'num_tel' => $request->num_tel,
            'tipo' => $request->tipo
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function auth(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    "error" => "Credenciales invalidas"
                ], 400);
            }
        }catch(JWTException $e){
            return response()->json([
                "error" => $e->getMessage(),
            ]);
        }

        $user = JWTAuth::user();
        return response()->json([
            "token" => $token,
            "user" => $user
        ]);
    }
    public function userProfile($id){
        $user = User::find($id);
        $comentarios = $user->comentarios()->with('users')
        ->get();

        $user->comentarios = $comentarios;
        return response()->json([
            "msg"=>"user profile", 
            "data" => $user
        ], 200);
    }

    public function logout(){
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(["msg" => "sesion cerrada correctamente"]);
        }catch(JWTException $e){
            return response()->json(["msg" => "ocurrio un error al cerrar sesion"]);
        }
    }
}
