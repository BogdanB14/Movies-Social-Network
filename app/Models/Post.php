<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'title',
        'content', //Sam tekst o filmu
        'user_id', //User-id - ovo je spoljni kljuc ka  tabeli User
        'movie_id',
        'created_at'
    ];
    //Spoljni kljucevi trebaju biti u guarded i timestamps
    protected $guarded = [
        'post_id', //Id post-a

    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id'); // Foreign key is movie_id
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); // Foreign key is user_id
    }
}
