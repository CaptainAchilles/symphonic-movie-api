<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];


    /**
     * Get the genres associated with the movie.
     */
    public function movies()
    {
        return $this->hasMany(\App\MoviesInGenre::class);
    }

    /**
     * Get the actors associated with the movie.
     */
    public function actors()
    {
        return $this->hasMany(\App\MoviesInGenre::class);
    }


}
