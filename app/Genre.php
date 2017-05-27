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
        return $this->belongsTo('Movie');
    }

    /**
     * Get the actors associated with this movie.
     */
    public function genres()
    {
        return $this->belongsTo('Genre');
    }
}
