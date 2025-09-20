<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'by_user',
        'for_movie',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'by_user');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'for_movie');
    }
}
