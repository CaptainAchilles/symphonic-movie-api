<?php namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Movie;

class MovieDelete extends Mutation {

	protected $attributes = [
		'name' => 'MovieDelete'
	];

	public function type()
	{
		return Type::boolean();
	}

	public function args()
	{
		return [
			'id' => ['name' => 'id', 'type' => Type::nonNull(Type::string())]
		];
	}

	public function resolve($root, $args)
	{

		$movie = Movie::find($args["id"]);
        if ($movie) {
            \App\MoviesInGenre::where("movie_id", $movie->id)->delete();
            \App\ActorsInMovie::where("movie_id", $movie->id)->delete();
		    return $movie->delete();
        }
        return false;
	}

}
