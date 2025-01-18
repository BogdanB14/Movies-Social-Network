<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchPosts(Request $request)
    {
        $query = $request->input('query');

        // Pretraga postova po naslovu i sadržaju
        $posts = Post::where('title', 'like', "%{$query}%")
                     ->orWhere('text', 'like', "%{$query}%")
                     ->get();

        return response()->json($posts);
    }
}
