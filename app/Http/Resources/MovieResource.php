<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    public static $wrap = 'movie';

    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'director'    => $this->director,
            'year'        => $this->year,
            'genre'       => $this->genre,
            'description' => $this->description,
            'actors'      => $this->actors,
            'poster'      => $this->poster,

            // Optionally include comments only when eager-loaded
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
