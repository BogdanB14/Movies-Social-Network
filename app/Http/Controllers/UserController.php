<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function showUser($user_id)
    {
        $user = User::find($user_id);

        if ($user === null) {
            return response()->json('User not found', 404);
        }

        return response()->json($user);
    }
}
