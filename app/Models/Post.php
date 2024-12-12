<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'content' //Sam tekst o filmu

    ];
    //Spoljni kljucevi trebaju biti u guarded i timestamps
    protected $guarded = [
        'post_id', //Id post-a
        'user_id', //User-id - ovo je spoljni kljuc ka  tabeli User
        'movie_name', // Naziv filma - spoljni kljuc ka tabeli Film
        'movie_year', // Datum filma - spoljni kljuc ka tabeli Film
        'created_at'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class); //Zato sto ima vezu 1,1 ka movie
    }

    public function user()
    {
        return $this->belongsTo(User::class); //Zato sto ima vezu 1,1 ka user-u
    }
}
