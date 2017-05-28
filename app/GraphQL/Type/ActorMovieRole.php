<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class ActorMovieRole extends BaseType
{
    protected $attributes = [
        'name' => 'ActorMovieRole',
        'description' => 'A type'
    ];
    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The movie id'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the character in this movie'
            ]
        ];
    }
}
