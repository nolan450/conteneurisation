<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable   = [
        "name"
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'categories_movies', "category_id", "movie_id");
    }
}
