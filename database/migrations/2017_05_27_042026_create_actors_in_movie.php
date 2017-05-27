<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorsInMovie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actors_in_movie', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('actor_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->string('character_name');
        });

        Schema::table("actors_in_movie", function($table) {
            $table->foreign("actor_id")
                ->references("id")->on("actors");
            $table->foreign("genre_id")
                ->references("id")->on("genres");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actors_in_movie');
    }
}
