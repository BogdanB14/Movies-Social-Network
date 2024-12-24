<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

    public function findPost($user_id, $movie_id)
    {
        $post = Post::with(['user', 'movie'])
                    ->where('user_id', $user_id)
                    ->where('movie_id', $movie_id)
                    ->firstOrFail();

        return new PostResource($post);
    }


    public function storeMieuw(Request $request){ //Tamara voli macke
      $validator = Validator::make($request->all(), [
          'title' => 'required|string|max:40',
          'content' => 'required|string|max:255',
          'movie_id' => 'required|exists:movies,movie_id',
          'user_id' => 'required|exists:users,id',

      ]);

      if ($validator->fails()){
          return response()->json($validator->errors());
}


      $post = Post::create([
          'title' => $request->title,
          'content' => $request->content,
          'movie' => $request->movie_id,
          'user_id' => Auth::user()->id,
      ]);

      return response()->json(['Post created successfully.', new PostResource($post)]);
  }

  public function updateMieuw(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
          'title' => 'required|string|max:40',
          'content' => 'required|string|max:255'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

            $post->title = $request->title;
            $post->content = $request->content;

        $post->save();

        return response()->json(['Post is updated successfully.', new PostResource($post)]);
    }

    public function goodbye(Post $post)
    {
        $post->delete();
        return response()->json('Post is deleted successfully.');
    }
}
