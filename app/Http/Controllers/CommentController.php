<?php

// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'content' => 'required|string|max:5000',
            'for_movie' => 'required|integer|exists:movies,id',
        ]);
        $comment = Comment::create([
            'content' => $data['content'],
            'for_movie' => $data['for_movie'],
            'by_user' => $r->user()->id,
        ]);
        return response()->json(['success' => true, 'data' => $comment], 201);
    }

    public function destroy($id)
    {
        $c = Comment::find($id);
        if (!$c)
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        $c->delete();
        return response()->json(['success' => true, 'message' => 'Deleted']);
    }
}
