<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uid';
    public $timestamps    = false;
    public $fillable      = [
        "name",
        "description",
        "rate",
        "duration",
    ];

    /*protected $casts = [
        'uuid' => 'string',
    ];

    protected $hidden = ['uuid'];*/

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_movies', "movie_id", "category_id");
    }
}
