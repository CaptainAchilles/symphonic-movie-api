<?php namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Folklore\GraphQL\Error\ValidationError;
use App\Actor;
use App\Movie;
use \App\ActorsInMovie;

class ActorMutation extends Mutation {

	protected $attributes = [
		'name' => 'ActorMutation'
	];

	public function type()
	{
		return GraphQL::type('ActorType');
	}

	public function args()
	{
		return [
			'id' => ['name' => 'id', 'type' => Type::id()],
			'name' => ['name' => 'name', 'type' => Type::string()],
			'birth_date' => ['name' => 'birth_date', 'type' => Type::string()],
			'bio' => ['name' => 'bio', 'type' => Type::string()],
			'image' => ['name' => 'image', 'type' => Type::string()],

			'movies' => ['name' => 'movies', 'type' => Type::listOf(GraphQL::type('ActorMovieRole'))]
		];
	}

	public function resolve($root, $args)
	{
		$actor = null;
		if (isset($args["id"])) {
			$actor = Actor::find($args["id"]);
		} else {
			$actor = new Actor();
		}
		if(!$actor) {
			return null;
		}
		foreach (["name", "birth_date", "bio", "image"] as $actorProp) {
			if (isset($args[$actorProp])) {
				if ($actorProp == "birth_date") {
					$actor->birth_date = date_create($args["birth_date"]);
					$actor->age = $actor->birth_date->diff(date_create('now'))->format('%y');
				} else {
					$actor->$actorProp = $args[$actorProp];
				}
			} else if (!isset($args["id"])) {
				throw new ValidationError("Missing required property on Actor: $actorProp");
			}
		}

		$actor->save();
		if (isset($args['movies'])) {
			// Get all existing movies this actor was in
			$actorMovies = collect($args["movies"])->keyBy("id");
			$actorMovieIds = $actorMovies->map(function($movie) {
				return $movie['id'];
			});
			$existingMovies = Movie::whereIn("id", $actorMovieIds)->get()->keyBy("id");

			// If the given list of movie IDs doesn't match up with the existing movies then rollback and throw an error
			foreach($actorMovieIds as $id) {
				if ($existingMovies->get($id) == null) {
					$actor->delete();
					throw new ValidationError("Movie ID does not exist: $id");
				}
			}

			// Associate this actor with all the movies they were in
			foreach ($existingMovies as $key => $value) {
				$uniquePair = [
					"movie_id" => $key,
					"actor_id" => $actor->id
				];
				if (ActorsInMovie::where($uniquePair)->get()->count() == 0) {
					$newLookup = new ActorsInMovie();
					$newLookup->movie_id = $key;
					$newLookup->actor_id = $actor->id;
					$newLookup->character_name = $actorMovies->get($key)["name"];
					$newLookup->save();
				}
			}
		}
		return $actor;
	}

}
