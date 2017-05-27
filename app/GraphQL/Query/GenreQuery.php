<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query as BaseQuery;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class GenreQuery extends BaseQuery
{
    protected $attributes = [
        'name' => 'GenreQuery',
        'description' => 'A query'
    ];

    protected function type()
    {
        return Type::listOf(GraphQL::type('GenreType'));
    }

    protected function args()
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
            $genres = \App\Genre::where("id", $args["id"]);
        } else {
            $genres = \App\Genre::query();
        }
        $fields = $info->getFieldSelection($depth = 3);
		foreach ($fields as $field => $keys) {
			if ($field === 'movies') {
				$genres->with('movies.movies');
			} else if ($field === 'actors') {
				$genres->with('movies.movies');
			}
		}

        return $genres->get();
    }
}
