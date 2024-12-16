<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'post';
    public function toArray(Request $request): array
    {
        return [
            'movie_name' => $this->movie ? $this->movie->title : null,
            'release_year' => $this->movie ? $this->movie->year : null,
            'name' => $this->user ? $this->user->username : null,
            'genre' => $this->movie ? $this->movie->genre : null
        ];
    }
}
