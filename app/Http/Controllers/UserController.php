<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function getUsers(){
        $users = User::all();

        // $products = Product::where('estado', 1)
        // ->addSelect(['categoria' => Category::select('nombre')->whereColumn('category_id', 'id')])
        // ->get();
        return response()->json($users, 200);
    }
}
