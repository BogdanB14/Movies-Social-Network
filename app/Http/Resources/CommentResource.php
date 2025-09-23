<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public static $wrap = 'comment';

    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'content'   => $this->content,
            'created_at'=> $this->created_at?->toDateTimeString(),
            'user' => new UserResource($this->whenLoaded('user')),

            'movie' => $this->whenLoaded('movie', function () {
                return [
                    'id'       => $this->movie->id,
                    'title'    => $this->movie->title,
                    'year'     => $this->movie->year,
                    'genre'    => $this->movie->genre,
                    'director' => $this->movie->director,
                ];
            }),
        ];
    }
}
