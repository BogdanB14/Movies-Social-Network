<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Http\Resources\UserResource;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'min:6', 'max:50', 'unique:users,username'],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => $data['password'],
            'name' => $data['name'] ?? $data['username'],
            'last_name' => $data['last_name'] ?? null,
            'role' => 'client',
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'user' => $this->userDto($user),
        ], 201);
    }

    public function login(Request $request)
    {
        $creds = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($creds['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!Auth::attempt([$field => $creds['username'], 'password' => $creds['password']], true)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 422);
        }

        $request->session()->regenerate();

        return (new UserResource($request->user()))
            ->additional(['success' => true]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true, 'message' => 'Logged out.']);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $this->userDto($request->user()),
        ]);
    }

    private function userDto(User $u)
    {
        return [
            'id' => $u->id,
            'username' => $u->username,
            'name' => $u->name,
            'last_name' => $u->last_name,
            'email' => $u->email,
            'role' => $u->role,
        ];
    }
}
