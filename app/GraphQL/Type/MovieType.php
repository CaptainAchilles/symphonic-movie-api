<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class MovieType extends BaseType
{
    protected $attributes = [
        'name' => 'MovieType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The movie id'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The movie name'
            ],
            'rating' => [
                'type' => Type::string(),
                'description' => 'The rating of the movie'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'A description of the movie'
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'An image of the movie box art'
            ],
            'genres' => [
                'type' => Type::listOf(GraphQL::type('GenreType')),
                'description' => 'A list of genres this movie belongs to'
            ],
            'actors' => [
                'type' => Type::listOf(GraphQL::type('ActorType')),
                'description' => 'A list of actors in this movie'
            ],
        ];
    }
    public function resolveActorsField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
        return $root->actors()->get()
            ->flatMap(function($movieLookup) {
                return $movieLookup->actors()->get();
            })->filter(function($node) use ($args) {
                return isset($args["id"]) ? $node->id == $args["id"] : true;
            });
    }
    public function resolveGenresField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
        return $root->genres()->get()
            ->flatMap(function($movieLookup) {
                return $movieLookup->genres()->get();
            })->filter(function($node) use ($args) {
                return isset($args["id"]) ? $node->id == $args["id"] : true;
            });
    }
}
