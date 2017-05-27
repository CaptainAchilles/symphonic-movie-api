<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name');
            $table->integer("genre_id")->unsigned();
            $table->integer('rating');
            $table->string('description');
            $table->binary('image');
        });

        Schema::table("movies", function($table) {
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
        Schema::dropIfExists('movies');
    }
}
