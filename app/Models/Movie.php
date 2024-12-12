<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'year_of_release',
        'genre',
        'director',
        'language'
    ];

    protected $guarded = [
        'movie_id'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
