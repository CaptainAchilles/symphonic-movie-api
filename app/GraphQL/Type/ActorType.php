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

    protected function fields()
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
                'description' => 'Movies the actors was in'
            ],

        ];
    }

    public function resolveMoviesField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
        return $root->movies()->get()
            ->flatMap(function($movieLookup) use ($root) {
                return $movieLookup->movies()->get();
            });
    }
    public function resolveCharactersField($root, $args, $context, GraphQL\Type\Definition\ResolveInfo $info)
    {
        return $root->movies()->get()
            ->map(function($movieLookup) {
                return [
                    'id' => $movieLookup->movie_id,
                    'name' => $movieLookup->character_name
                ];
            });
    }
}
