<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

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

    public function login(Request $request)
    {
        if (!(Auth::attempt($request->only('username', 'password'))))
	    {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Zdravo user ' . $user->name . ', dobrodosao', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return['message' => 'You have succesfully logged out.'];
    }


    public function loginAdmin(Request $request)
    {
        if (!Auth::guard('admin')->attempt($request->only('email',   'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $admin = Admin::where('email', $request['email'])->firstOrFail();

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Zdravo kmete ' . $admin->name . ', dobrodosao kuci', 'access_token' => $token, 'token_type' => 'Bearer']);
    }
}
