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
            'movie_name' => $this->movie->title, // assuming 'name' is a field in the 'movies' table
            'release_year' => $this->movie->year_of_release,
            'name' => $this->user->name, // assuming 'username' is a field in the 'users' table
            'genre' => $this->movie->genre
        ];
    }
}
