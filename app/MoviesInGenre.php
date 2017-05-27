<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoviesInGenre extends Model
{
    public $timestamps = null;

    public function movies() {
        return $this->hasMany(\App\Movie::class, 'id', 'movie_id');
    }

}
