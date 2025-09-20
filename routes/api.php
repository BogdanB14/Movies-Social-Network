<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file exposes:
| - Resource route (movies: index, show)
| - Query-string route: /movies/search?title=...
| - Param route:       /movies/by-title/{title}
| - Protected routes with Sanctum + role middleware
|
| NOTE: We keep response shapes consistent with your frontend:
|   - /api/movies (index) => { success, data: pagination }
|   - /api/movies/search  => movie object (raw) or 404 with { success:false, message }
|   - /api/movies/by-title/{title} => movie object (raw) or 404
*/

Route::pattern('movie', '[0-9]+');

/* ------------------------- Auth (public) ------------------------- */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);

/* --------------------- Movies (public read) ---------------------- */
// Resource route: GET /api/movies, GET /api/movies/{movie}
Route::apiResource('movies', MovieController::class)->only(['index', 'show']);

// Type 2: query-string search: GET /api/movies/search?title=Inception
Route::get('/movies/search', [MovieController::class, 'searchByTitle'])->name('movies.search');

// Type 1: route-parameter search: GET /api/movies/by-title/{title}
Route::get('/movies/by-title/{title}', [MovieController::class, 'showByTitle'])->name('movies.byTitle');

/* --------------------- Protected (needs login) ------------------- */
Route::middleware('auth:sanctum')->group(function () {



    // Comments: client/moderator/admin can add; moderator/admin can delete
    Route::post('/comments', [CommentController::class, 'store'])->middleware('role:client,moderator,admin');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->middleware('role:moderator,admin');

    // Movies: only admin can create/delete
    Route::post('/movies', [MovieController::class, 'store'])->middleware('role:admin');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->middleware('role:admin');
    Route::delete('/movies/by-title/{title}', [MovieController::class, 'destroyByTitle'])->middleware('role:admin');
});

Route::get('/movies/{movie}/comments', [CommentController::class, 'indexForMovie'])->name('movies.comments.index');
Route::get('/comments/by-movie-title/{title}', [CommentController::class, 'indexByMovieTitle'])->name('comments.byMovieTitle');

Route::get('/users/{user}/comments', [CommentController::class, 'indexForUser'])
    ->name('users.comments.index');
