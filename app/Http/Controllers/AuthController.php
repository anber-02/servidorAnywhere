<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(Request $request){
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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // if($validator->fails()){
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);

            return response(["token" => $token], 200)->withoutCookie($cookie);
        }else{
            return response()->json(['msg'=>'no authorizado'], 401);
        }
    }

    public function userProfile(Request $request){
        return response()->json([
            "msg"=>"user profile", 
            "data" => auth()->user()
        ], 200);
    }
}
