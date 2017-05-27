<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorsInMovies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actors_in_movies', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('actor_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->string('character_name');
        });

        Schema::table("actors_in_movies", function($table) {
            $table->foreign("actor_id")
                ->references("id")->on("actors");
            $table->foreign("movie_id")
                ->references("id")->on("movies");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actors_in_movies');
    }
}
