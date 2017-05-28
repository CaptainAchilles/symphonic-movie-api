<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query as BaseQuery;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class MovieQuery extends BaseQuery
{
    protected $attributes = [
        'name' => 'MovieQuery',
        'description' => 'A query which gets movies'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('MovieType'));
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::id(),
                'description' => 'The genre id'
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        if (!empty($args["id"])) {
            $movies = \App\Movie::where("id", $args["id"]);
        } else {
            $movies = \App\Movie::query();
        }
        $fields = $info->getFieldSelection($depth = 3);
		foreach ($fields as $field => $keys) {
			if ($field === 'genres') {
				$movies->with('genres');
			} else if ($field === 'actors') {
				$movies->with('actors');
			}
		}

        return $movies->get();
    }
}
