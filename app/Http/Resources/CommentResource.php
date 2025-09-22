<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'comment';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at?->toDateTimeString(),

            // User podaci
            'user' => [
                'id' => $this->user?->id,
                'username' => $this->user?->username,
                'name' => $this->user?->name,
                'last_name' => $this->user?->last_name,
                'role' => $this->user?->role,
            ],

            // Movie podaci
            'movie' => [
                'id' => $this->movie?->id,
                'title' => $this->movie?->title,
                'year' => $this->movie?->year,
                'genre' => $this->movie?->genre,
                'director' => $this->movie?->director,
            ],
        ];
    }
}
