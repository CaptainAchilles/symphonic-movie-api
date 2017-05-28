<?php namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Movie;

class MovieMutation extends Mutation {

	protected $attributes = [
		'name' => 'MovieMutation'
	];

	public function type()
	{
		return Type::listOf(GraphQL::type('MovieType'));
	}

	public function args()
	{
		return [
			'id' => ['name' => 'id', 'type' => Type::id()],
			'name' => ['name' => 'name', 'type' => Type::string()],
			'rating' => ['name' => 'rating', 'type' => Type::string()],
			'description' => ['name' => 'description', 'type' => Type::string()],
			'image' => ['name' => 'image', 'type' => Type::string()],

			'actors' => ['name' => 'actors', 'type' => Type::listOf(Type::id())],
            'genres' => ['name' => 'genres', 'type' => Type::listOf(Type::id())],
		];
	}

	public function resolve($root, $args)
	{
		$movie = null;
		if (isset($args["id"])) {
			$movie = Movie::find($args["id"]);
		} else {
			$movie = new Movie();
		}
		if(!$movie) {
			return null;
		}
		foreach (["name", "rating", "description", "image"] as $movieProp => $_) {
			if (isset($args[$movieProp])) {
                $movie->$movieProp = $args[$movieProp];
			} else if (!isset($args["id"])) {
				throw new ValidationError("Missing required property on Movie: $movieProp");
			}
		}

		// Update related tables
		if (isset($args['actors'])) {
			$makeMovies = (new ActorMutation())->resolve($root, $args["actors"]);
		}
        if (isset($args['genres'])) {
			$makeMovies = (new GenreMutation())->resolve($root, $args["genres"]);
		}

        $movie->save();

		return $movie;
	}

}
