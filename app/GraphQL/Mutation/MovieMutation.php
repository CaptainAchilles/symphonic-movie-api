<?php namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Folklore\GraphQL\Error\ValidationError;
use App\Movie;

class MovieMutation extends Mutation {

	protected $attributes = [
		'name' => 'MovieMutation'
	];

	public function type()
	{
		return GraphQL::type('MovieType');
	}

	public function args()
	{
		return [
			'id' => ['name' => 'id', 'type' => Type::id()],
			'name' => ['name' => 'name', 'type' => Type::string()],
			'rating' => ['name' => 'rating', 'type' => Type::string()],
			'description' => ['name' => 'description', 'type' => Type::string()],
			'image' => ['name' => 'image', 'type' => Type::string()],

            // Must add movies, then individual separately data at the moment.
			// 'actors' => ['name' => 'actors', 'type' => Type::listOf(Type::id())],
            // 'genres' => ['name' => 'genres', 'type' => Type::listOf(Type::id())],
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
		foreach (["name", "rating", "description", "image"] as $movieProp) {
			if (isset($args[$movieProp])) {
                $movie->$movieProp = $args[$movieProp];
			} else if (!isset($args["id"])) {
				throw new ValidationError("Missing required property on Movie: $movieProp");
			}
		}

        $movie->save();
		return $movie;
	}

}
