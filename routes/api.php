<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CommentController;


Route::post('/login', [AuthController::class, 'login'])->middleware('web');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('web');
Route::get('/me', [AuthController::class, 'me'])->middleware('web');
Route::pattern('movie', '[0-9]+');
Route::post('/register', [AuthController::class, 'register']);

Route::apiResource('movies', MovieController::class)->only(['index', 'show']);

Route::get('/movies/search', [MovieController::class, 'searchByTitle'])->name('movies.search');
Route::get('/movies/by-title/{title}', [MovieController::class, 'showByTitle'])->name('movies.byTitle');

/* --------------------- Protected, potrebna prijava ------------------- */
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])
        ->middleware('role:client,moderator,admin');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->middleware('role:moderator,admin');

    Route::post('/movies', [MovieController::class, 'store'])->middleware('role:admin');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->middleware('role:admin');
    Route::delete('/movies/by-title/{title}', [MovieController::class, 'destroyByTitle'])->middleware('role:admin');
});

Route::get('/movies/{movie}/comments', [CommentController::class, 'indexForMovie'])
    ->name('movies.comments.index');

Route::get('/comments/by-movie-title/{title}', [CommentController::class, 'indexByMovieTitle'])
    ->name('comments.byMovieTitle');

Route::get('/users/{user}/comments', [CommentController::class, 'indexForUser'])
    ->name('users.comments.index');
