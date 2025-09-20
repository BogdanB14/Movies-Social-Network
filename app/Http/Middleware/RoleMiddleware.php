<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }
        if (!in_array(strtolower($user->role ?? 'client'), array_map('strtolower', $roles))) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }
        return $next($request);
    }
}
