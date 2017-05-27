<?php

use Illuminate\Database\Seeder;

class MoviesInGenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MoviesInGenre::class, 5)->create();
    }
}
