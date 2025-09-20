<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    /**
     * GET /api/movies
     * Returns paginated list wrapped as { success, data: pagination }
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 24);
        $perPage = max(1, min($perPage, 100));

        $movies = Movie::select('id', 'title', 'director', 'genre', 'year', 'description', 'actors', 'poster')
            ->latest('id')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $movies,
        ]);
    }

    /**
     * GET /api/movies/{movie}
     * Returns { success, data: movie }
     */
    public function show(Movie $movie)
    {
        return response()->json([
            'success' => true,
            'data' => $movie,
        ]);
    }

    /**
     * GET /api/movies/search?title=Inception
     * Returns the movie object (raw) so your frontend can do: this.movie = res.data
     */
    public function searchByTitle(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $title = urldecode($request->query('title'));
        $movie = Movie::whereRaw('LOWER(title) = ?', [mb_strtolower($title)])->first();

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found.',
            ], 404);
        }

        return response()->json($movie); // raw object (frontend expects this)
    }

    /**
     * GET /api/movies/by-title/{title}
     * Also returns the movie object (raw)
     */
    public function showByTitle(string $title)
    {
        $decoded = urldecode($title);
        $movie = Movie::whereRaw('LOWER(title) = ?', [mb_strtolower($decoded)])->first();

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found.',
            ], 404);
        }

        return response()->json($movie); // raw object
    }

    /**
     * POST /api/movies (admin)
     * Accepts multipart/form-data with:
     *  - title, director, year, genre, description (strings)
     *  - actors[] as array of strings
     *  - poster as file image (required by your UI)
     * Saves file to storage/app/public/posters and stores URL in DB (string).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1888', 'max:3000'],
            'genre' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'actors' => ['nullable', 'array'],
            'actors.*' => ['string', 'max:255'],
            'poster' => ['required', 'file', 'image', 'max:5120'], // 5MB
        ]);

        $posterUrl = null;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $slug = Str::slug($data['title']);
            $ext = $file->getClientOriginalExtension();
            $filename = $slug . '-' . Str::random(8) . '.' . $ext;

            $path = $file->storeAs('posters', $filename, 'public'); // storage/app/public/posters/...
            $posterUrl = Storage::disk('public')->url($path);            // /storage/posters/...
        }

        $movie = Movie::create([
            'title' => $data['title'],
            'director' => $data['director'],
            'year' => $data['year'],
            'genre' => $data['genre'],
            'description' => $data['description'],
            'actors' => $data['actors'] ?? [],
            'poster' => $posterUrl,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Film je uspešno dodat.',
            'data' => $movie,
        ], 201);
    }

    /**
     * DELETE /api/movies/{movie} (admin)
     * Deletes the movie and its local poster file if applicable.
     */
    public function destroy(Movie $movie)
    {
        // If it's a local file (served via /storage), remove it
        if ($movie->poster && str_starts_with($movie->poster, url('/storage') . '/')) {
            $relative = str_replace(url('/storage') . '/', '', $movie->poster); // posters/filename.jpg
            Storage::disk('public')->delete($relative);
        }

        $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie deleted.',
        ]);
    }

    /**
     * DELETE /api/movies/by-title/{title} (admin)
     * Deletes by title (case-insensitive) and also cleans local poster.
     */
    public function destroyByTitle(string $title)
    {
        $decoded = urldecode($title);
        $movie = Movie::whereRaw('LOWER(title) = ?', [mb_strtolower($decoded)])->first();

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found.',
            ], 404);
        }

        if ($movie->poster && str_starts_with($movie->poster, url('/storage') . '/')) {
            $relative = str_replace(url('/storage') . '/', '', $movie->poster);
            Storage::disk('public')->delete($relative);
        }

        $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie deleted.',
        ]);
    }
}
