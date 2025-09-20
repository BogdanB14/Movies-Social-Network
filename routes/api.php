<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CommentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Comments: everyone logged-in can add; admin/moderator can delete
    Route::post('/comments', [CommentController::class, 'store'])
        ->middleware('role:client,moderator,admin');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])
        ->middleware('role:moderator,admin');

    // Movies: only admin add/delete
    Route::post('/movies', [MovieController::class, 'store'])
        ->middleware('role:admin');
    Route::delete('/movies/{id}', [MovieController::class, 'destroy'])
        ->middleware('role:admin');
});

// Public examples:
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
