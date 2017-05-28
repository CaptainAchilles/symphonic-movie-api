<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class ActorType extends BaseType
{
    protected $attributes = [
        'name' => 'ActorType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The actor id'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The actors name'
            ],
            'age' => [
                'type' => Type::string(),
                'description' => 'The age of the actor'
            ],
            'birth_date' => [
                'type' => Type::string(),
                'description' => 'The birth date of the actor'
            ],
            'bio' => [
                'type' => Type::string(),
                'description' => 'A short biography of the actor'
            ],
            'characters' => [
                'type' => Type::listOf(GraphQL::type('ActorCharacterType')),
                'description' => 'The characters played by the actor'
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'An image of the actor'
            ],
            'movies' => [
                'type' => Type::listOf(GraphQL::type('MovieType')),
                'description' => 'Movies the actors was in',
                'args' => [
                    'id' => [
                        'type' => Type::id(),
                        'description' => 'ID of the actor'
                    ]
                ]
            ],
            'genres' => [
                'type' => Type::listOf(GraphQL::type('GenreType')),
                'description' => 'Genres the actors has played in',
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
        return $root->movies()->get()
            ->flatMap(function($movieLookup) {
                return $movieLookup->movies()->get();
            })->filter(function($node) use ($args) {
                return isset($args["id"]) ? $node->id == $args["id"] : true;
            });
    }
    public function resolveGenresField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
       return $root->movies()->get()
            ->flatMap(function($movieLookup) {
                return $movieLookup->movies()->get();
            })->flatMap(function($movie) {
                return $movie->genres()->get();
            })->flatMap(function($genreLookup) {
                return $genreLookup->genres()->get();
            })->filter(function($node) use ($args) {
                return isset($args["id"]) ? $node->id == $args["id"] : true;
            });
    }

    public function resolveCharactersField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
       return $root->movies()->get()
            ->map(function($movieLookup) {
                return (object) [
                    'id' =>  $movieLookup->movie_id,
                    'name' => $movieLookup->character_name
                ];
            })->filter(function($node) use ($args) {
                return isset($args["id"]) ? $node->id == $args["id"] : true;
            });
    }
}
