<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    /**
     * GET /api/movies/{movie}/comments
     */
    public function indexForMovie(Movie $movie)
    {
        $comments = $movie->comments()
            ->with(['user:id,username,name,last_name,role', 'movie:id,title,year,genre,director'])
            ->latest('id')
            ->get();

        return CommentResource::collection($comments)
            ->additional(['success' => true]);
    }

    /**
     * GET /api/comments/by-movie-title/{title}
     */
    public function indexByMovieTitle(string $title)
    {
        $decoded = urldecode($title);

        $movie = Movie::whereRaw('LOWER(title) = ?', [mb_strtolower($decoded)])->first();
        if (!$movie) {
            return response()->json(['success' => false, 'message' => 'Movie not found.'], 404);
        }

        $comments = Comment::query()
            ->with(['user:id,username,name,last_name,role', 'movie:id,title'])
            ->where('for_movie', $movie->id)
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $comments->map(fn($c) => $this->dto($c))->values(),
        ]);
    }

    /**
     * POST /api/comments
     * Body: content + (for_movie OR movie_title)
     * Protected: role client/moderator/admin
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'content' => ['required', 'string', 'max:5000'],
            'for_movie' => ['nullable', 'integer', 'exists:movies,id', 'required_without:movie_title'],
            'movie_title' => ['nullable', 'string', 'max:255', 'required_without:for_movie'],
        ]);

        $movieId = $data['for_movie'] ?? null;
        if (!$movieId) {
            $title = $data['movie_title'];
            $movieId = Movie::whereRaw('LOWER(title) = ?', [mb_strtolower($title)])->value('id');
            if (!$movieId) {
                return response()->json(['success' => false, 'message' => 'Movie not found.'], 404);
            }
        }

        $comment = Comment::create([
            'content' => $data['content'],
            'for_movie' => $movieId,
            'by_user' => $r->user()->id,
        ]);

        $comment->load(['user:id,username,name,last_name,role', 'movie:id,title']);

        return response()->json([
            'success' => true,
            'data' => $this->dto($comment),
        ], 201);
    }

    /**
     * DELETE /api/comments/{comment}
     * Protected: role moderator/admin
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted.',
        ]);
    }

    public function indexForUser(User $user)
    {
        $comments = Comment::query()
            ->with(['user:id,username,name,last_name,role', 'movie:id,title'])
            ->where('by_user', $user->id)
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $comments->map(fn($c) => $this->dto($c))->values(),
        ]);
    }

    private function dto(Comment $c): array
    {
        return [
            'id' => $c->id,
            'content' => $c->content,
            'created_at' => $c->created_at,
            'user' => $c->relationLoaded('user') && $c->user ? [
                'id' => $c->user->id,
                'username' => $c->user->username,
                'name' => $c->user->name,
                'last_name' => $c->user->last_name,
                'role' => $c->user->role,
            ] : null,
            'movie' => $c->relationLoaded('movie') && $c->movie ? [
                'id' => $c->movie->id,
                'title' => $c->movie->title,
            ] : null,
        ];
    }
}
