<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rating', 'description', 'image'
    ];


    /**
     * Get the genres associated with the movie.
     */
    public function genre()
    {
        return $this->hasMany('Genre');
    }

    /**
     * Get the actors associated with this movie.
     */
    public function actors()
    {
        return $this->hasMany(\App\ActorsInMovie::class);
    }
}
