<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    /**
     * GET /api/movies/by-slug/{slug}
     */
    public function showBySlug(string $slug): JsonResponse
    {
        $movie = Movie::where('slug', $slug)->first();

        if (!$movie) {
            return response()->json(['message' => 'Film nije pronađen.'], 404);
        }

        // Model has poster_url accessor; it will be included automatically if $appends used
        return response()->json(['movie' => $movie]);
    }

    /**
     * GET /api/movies/show?title=Inception
     */
    public function showByTitle(Request $request): JsonResponse
    {
        $title = $request->query('title');
        if (!$title) {
            return response()->json(['message' => 'Nedostaje naslov.'], 422);
        }

        $movie = Movie::where('title', $title)->orderByDesc('id')->first();

        if (!$movie) {
            return response()->json(['message' => 'Film nije pronađen.'], 404);
        }

        return response()->json(['movie' => $movie]);
    }

    /**
     * POST /api/movies  (protected: auth:sanctum + gate in StoreMovieRequest@authorize)
     */
    public function store(StoreMovieRequest $request): JsonResponse
    {
        // Poster upload (required by StoreMovieRequest)
        $path = null;
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public'); // storage/app/public/posters/...
        }

        // Normalize actors: you send actors[] so this is already an array; sanitize anyway
        $actors = collect($request->input('actors', []))
            ->map(fn ($a) => is_string($a) ? trim($a) : $a)
            ->filter(fn ($a) => is_string($a) && $a !== '')
            ->values()
            ->all();

        $movie = Movie::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . uniqid(),
            'year'        => $request->year,
            'genre'       => $request->genre,
            'director'    => $request->director,     // 👈 added
            'description' => $request->description,
            'poster'      => $path,
            'actors'      => $actors,                // 👈 added (JSON cast in model)
            'created_by'  => $request->user()->id,   // Sanctum session user
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Film je uspešno dodat.',
            'movie'   => $movie,
        ], 201);
    }

    /**
     * DELETE /api/movies/{movie} (protected by route middleware)
     */
    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Film je uspešno obrisan.',
        ]);
    }

    /**
     * DELETE /api/movies/by-slug/{slug}
     */
    public function destroyBySlug(string $slug): JsonResponse
    {
        $movie = Movie::where('slug', $slug)->first();

        if (!$movie) {
            return response()->json(['message' => 'Film nije pronađen.'], 404);
        }

        $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Film je uspešno obrisan.',
        ]);
    }
}
