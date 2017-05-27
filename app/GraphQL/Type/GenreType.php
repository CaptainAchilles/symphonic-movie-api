<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class GenreType extends BaseType
{
    protected $attributes = [
        'name' => 'GenreType',
        'description' => 'A type'
    ];

    protected function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The genre id'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The genre name'
            ],
            'movies' => [
                'name' => 'movies',
                'type' => Type::listOf(GraphQL::type("MovieType")),
                'description' => 'The movies in this genre'
            ],
            'actors' => [
                'name' => 'actors',
                'type' => Type::listOf(GraphQL::type("ActorType")),
                'description' => 'The actors in this genre',
                'args' => [
                    'id' => [
                        'type' => Type::id(),
                        'description' => 'ID of the actor'
                    ]
                ]
            ]
        ];
    }
    public function resolveMoviesField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
        if (isset($root->movies)) {
            $root->movies = $root->movies
                ->map(function($movieLookup) {
                    return $movieLookup->movies()->get();
                })->flatten();
        } else {
            $root->movies = [];
        }
        return $root->movies;
    }
    public function resolveActorsField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
        // Fetch all unique actors from the movies
        if (isset($root->movies)) {
            $root->actors = $root->movies
                ->flatMap(function($movieLookup) {
                    return $movieLookup->movies()->get();
                })
                ->unique(function($movie) {
                    return $movie->actor_id;
                })
                ->flatMap(function($movie) {
                    return $movie->actors()->get();
                })
                ->flatMap(function($actorLookup) {
                    return $actorLookup->actors()->get();
                });
            if (isset($args['id'])) {
                $root->actors = $root->actors->filter(function($actor) use ($args) {
                    return $actor->id == $args['id'];
                });
            }
        } else {
            $root->actors = [];
        }
        return $root->actors;
    }
}
