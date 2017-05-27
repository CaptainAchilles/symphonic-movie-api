<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActorsInMovie extends Model
{
    public $timestamps = null;

    public function actors() {
        return $this->hasMany(\App\Actor::class, 'id', 'actor_id');
    }

    public function movies() {
        return $this->hasMany(\App\Movie::class, 'id', 'movie_id');
    }

}
