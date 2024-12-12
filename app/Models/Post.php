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
    protected $guarded = [
        'post_id', //Id post-a
        'user_id', //User-id - ovo je spoljni kljuc ka  tabeli User
        'movie_name', // Naziv filma - spoljni kljuc ka tabeli Film
        'movie_year', // Datum filma - spoljni kljuc ka tabeli Film

    ];
}
