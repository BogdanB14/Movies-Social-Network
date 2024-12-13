<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    // Get all posts
    public function index()
    {
        $posts = Post::all(); // Retrieve all posts
        return PostResource::collection($posts); // Return a collection of transformed posts
    }

    // Get a single post
    public function show($id)
    {
        $post = Post::findOrFail($id); // Find the post by ID or fail
        return new PostResource($post); // Return the transformed post
    }

    // Create a new post
    public function store(Request $request)
    {
        $post = Post::create($request->all()); // Create a new post
        return new PostResource($post); // Return the transformed post
    }

    // Update an existing post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id); // Find the post by ID
        $post->update($request->all()); // Update the post
        return new PostResource($post); // Return the transformed post
    }

    // Delete a post
    public function destroy($id)
    {
        $post = Post::findOrFail($id); // Find the post by ID
        $post->delete(); // Delete the post
        return response()->noContent(); // Return no content (successful deletion)
    }

}
