<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query as BaseQuery;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;


class ActorQuery extends BaseQuery
{
    protected $attributes = [
        'name' => 'ActorQuery',
        'description' => 'A query for actors'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('ActorType'));
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::id(),
                'description' => 'The actor id'
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        if (!empty($args["id"])) {
            $actors = \App\Actor::where("id", $args["id"]);
        } else {
            $actors = \App\Actor::query();
        }
        $fields = $info->getFieldSelection($depth = 3);
		foreach ($fields as $field => $keys) {
			if ($field === 'movies') {
				$actors->with('movies.movies');
			} else if ($field === 'actors') {
                // Load the movies relation to get the actors from the movies
				$actors->with('movies.movies');
			}
		}

        return $actors->get();
    }
}
