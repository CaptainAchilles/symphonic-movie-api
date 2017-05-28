<?php namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Folklore\GraphQL\Error\ValidationError;
use App\Genre;
use App\Movie;
use App\MoviesInGenre;

class GenreMutation extends Mutation {

	protected $attributes = [
		'name' => 'GenreMutation'
	];

	public function type()
	{
		return GraphQL::type('GenreType');
	}

	public function args()
	{
		return [
			'id' => ['name' => 'id', 'type' => Type::string()],
			'name' => ['name' => 'name', 'type' => Type::string()],

            'movies' => ['name' => 'movies', 'type' => Type::listOf(Type::id())],
		];
	}

	public function resolve($root, $args)
	{
		$genre = null;
		if (isset($args["id"])) {
			$genre = Genre::find($args["id"]);
		} else {
			$genre = new Genre();
		}
		if(!$genre) {
			return null;
		}

		foreach (["name"] as $genreProp) {
			if (isset($args[$genreProp])) {
                $genre->$genreProp = $args[$genreProp];
			} else if (!isset($args["id"])) {
				throw new ValidationError("Missing required property: $genreProp");
			}
		}

        $genre->save();
		if (isset($args['movies'])) {
			$existingMovies = Movie::whereIn("id", $args["movies"])->get()->keyBy("id");

			foreach($args["movies"] as $id) {
				if ($existingMovies->get($id) == null) {
					$genre->delete();
					throw new ValidationError("Movie ID does not exist: $id");
				}
			}
			foreach ($existingMovies as $key => $value) {
				$uniquePair = [
					"movie_id" => $key,
					"genre_id" => $genre->id
				];
				if (MoviesInGenre::where($uniquePair)->get()->count() == 0) {
					$newLookup = new MoviesInGenre();
					$newLookup->movie_id = $key;
					$newLookup->genre_id = $genre->id;
					$newLookup->save();
				}
			}
		}
		return $genre;
	}
}
