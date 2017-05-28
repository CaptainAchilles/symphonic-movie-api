<?php namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Actor;
use Folklore\GraphQL\Error\ValidationError;

class ActorDelete extends Mutation {

	protected $attributes = [
		'name' => 'ActorDelete'
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
		$actor = Actor::find($args["id"]);
        if ($actor) {
            \App\ActorsInMovie::where("actor_id", $actor->id)->delete();
            return $actor->delete();
        }
		return false;
	}

}
