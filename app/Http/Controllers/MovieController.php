<?php

// app/Http/Controllers/MovieController.php
namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'data' => Movie::latest()->paginate(12)]);
    }
    public function show($id)
    {
        $movie = Movie::with('comments.user:id,username,name,last_name,role')->find($id);
        if (!$movie)
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        return response()->json(['success' => true, 'data' => $movie]);
    }
    public function store(Request $r)
    {
        $data = $r->validate([
            'title' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'year' => 'required|integer|min:1888|max:3000',
            'genre' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'actors' => 'nullable|array',
            'actors.*' => 'string|max:255',
            'poster' => 'nullable|string|max:2048',
        ]);
        $movie = Movie::create($data);
        return response()->json(['success' => true, 'data' => $movie], 201);
    }
    public function destroy($id)
    {
        $m = Movie::find($id);
        if (!$m)
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        $m->delete();
        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}
