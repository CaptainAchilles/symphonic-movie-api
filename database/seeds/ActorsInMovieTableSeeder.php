<?php

use Illuminate\Database\Seeder;

class ActorsInMovieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ActorsInMovie::class, 5)->create();
    }
}
