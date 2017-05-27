<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesInGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies_in_genres', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('genre_id')->unsigned();
            $table->integer('movie_id')->unsigned();
        });

        Schema::table("movies_in_genres", function($table) {
            $table->foreign("genre_id")
                ->references("id")->on("genres");
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
        Schema::dropIfExists('movies_in_genres');
    }
}
