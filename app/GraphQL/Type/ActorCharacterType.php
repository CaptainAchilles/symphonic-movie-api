<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;


class ActorCharacterType extends BaseType
{
    protected $attributes = [
        'name' => 'ActorCharacterType',
        'description' => 'A type describing an actor with a character'
    ];

    protected function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The movie id'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the character'
            ]
        ];
    }

}