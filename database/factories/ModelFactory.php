<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
function getImage(Faker\Generator $faker) {
    $filePath = sys_get_temp_dir();
    $imagePath = $faker->image($filePath, 320, 320, false);
    $imageHandle = fopen($imagePath, "rb");
    return fread($imageHandle, filesize($imagePath));
}
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Actor::class, function (Faker\Generator $faker) {
    $birthDay = $faker->dateTime('now');
    return [
        'name' => $faker->name,
        'birth_date' => $birthDay,
        'age' => $birthDay->diff(date_create('now'))->format('%y'),
        'bio' => $faker->realText(200),
        'image' => getImage($faker)
    ];
});

$factory->define(\App\Genre::class, function (Faker\Generator $faker) {
    $existingGenres = \App\Genre::get(["name"]);
    $safeGenreName = $faker->colorName;
    while($existingGenres->contains($safeGenreName)) {
        $safeGenreName = $faker->colorName;
    }
    return [
        'name' => $safeGenreName
    ];
});

$factory->define(\App\Movie::class, function (Faker\Generator $faker) {
    $genreCount = \App\Genre::where("id", ">", "0")->get(["id"]);
    return [
        'name' => $faker->safeColorName,
        'rating' => $faker->numberBetween(0, 10),
        'description' => $faker->realText(200),
        'image' => getImage($faker),
        'genre_id' => $genreCount->random()
    ];
});

$factory->define(\App\ActorsInMovie::class, function (Faker\Generator $faker) {
    $allMovies = \App\Movie::get(["id"]);
    $allActors = \App\Actor::get(["id"]);
    return [
        'actor_id' => $allActors->random(),
        'movie_id' => $allMovies->random(),
        'character_name' => $faker->name
    ];
});

$factory->define(\App\MoviesInGenre::class, function (Faker\Generator $faker) {
    $allMovies = \App\Movie::get(["id"]);
    $allGenres = \App\Genre::get(["id"]);
    return [
        'genre_id' => $allGenres->random(),
        'movie_id' => $allMovies->random()
    ];
});
