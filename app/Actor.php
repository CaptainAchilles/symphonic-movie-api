<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'birth_date', 'age', 'bio', 'image'
    ];


    /**
     * Get the genres associated with the movie.
     */
    public function movies()
    {
        return $this->hasMany(\App\ActorsInMovie::class);

    }
}
