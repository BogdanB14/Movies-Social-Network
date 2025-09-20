<?php
// app/Models/Movie.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'director',
        'year',
        'genre',
        'description',
        'actors',
        'poster',
    ];

    protected $casts = [
        'actors' => 'array', // array of strings
    ];

    // comments (array of comment IDs is derived from relation)
    public function comments()
    {
        return $this->hasMany(Comment::class, 'for_movie');
    }

}
