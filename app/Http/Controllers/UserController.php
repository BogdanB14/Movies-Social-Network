<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUser($id){
        $user =  null;
        $user = User::find($id);
        if($user == null) 
            return response()->json('User not found', 404);
        else return response()->json($user);    
    }
}
