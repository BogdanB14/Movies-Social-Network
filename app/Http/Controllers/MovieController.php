<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Resources\MovieResource;

class MovieController extends Controller
{
    /**
     * GET /api/movies
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
     */
    public function show(Movie $movie)
    {
        $movie->load(['comments.user']);

        return (new MovieResource($movie))
            ->additional(['success' => true]);
    }

    /**
     * GET /api/movies/search?title=?
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

        return response()->json($movie);
    }
    /**
     * GET /api/movies/by-title/{title}
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

        return response()->json($movie);
    }
    /**
     * POST /api/movies (admin)
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
            'poster' => ['required', 'file', 'image', 'max:5120'],
        ]);
        $posterUrl = null;
        //Dodata funkcionalnost dodavanja fajlova:
        if ($request->hasFile('poster')) { //Da li je primljen file
            $file = $request->file('poster'); // Primljen fajl se cuva u promenljivu $file
            $slug = Str::slug($data['title']); //Pretvara u url frendly format -> 'The Godfather' -> 'the-godfather'
            $ext = $file->getClientOriginalExtension(); //u ext se cuva ekstenzija fajla, svg, png...
            $filename = $slug . '-' . Str::random(8) . '.' . $ext; //naziv fajla koji ce se cuvati, dodaju se 8 stringa da bi se izbeglo dupliranje fajlova (za svaki slucaj)

            $path = $file->storeAs('posters', $filename, 'public'); //putanja koja se cuva u storafe-u
            $posterUrl = Storage::disk('public')->url($path); //Memorisanje u storage-u sa vrednoscu posterUrl
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
     */
    public function destroy(Movie $movie)
    {
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
    /**
     * DELETE /api/movies/by-title/{title} (admin)
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
