<?php namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Genre;

class GenreDelete extends Mutation {

	protected $attributes = [
		'name' => 'GenreDelete'
	];

	public function type()
	{
		return Type::boolean();
	}

	public function args()
	{
		return [
			'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())]
		];
	}

	public function resolve($root, $args)
	{

		$genre = Genre::find($args["id"]);
        if ($genre) {
            \App\MoviesInGenre::where("genre_id", $genre->id)->delete();
		    return $genre->delete();
        }
        return false;
	}

}
