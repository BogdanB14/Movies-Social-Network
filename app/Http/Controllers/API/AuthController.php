<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255'
        ]);


        if ($validator->fails())
            return response()->json($validator->errors());

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_registration' => now()
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
		->json(['data' => $user, 'access_token' => $token,'token_type' => 'Bearer',]);
    }

    
}
