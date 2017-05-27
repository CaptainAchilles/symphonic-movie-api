<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Relay\Support\NodeType as BaseNodeType;
use GraphQL;

class UserNode extends BaseNodeType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'An user relay node'
    ];

    protected function fields()
    {
        return [
            // The id field here, will be automatically wrapped in the NodeIdField
            // and then resolve to a global id
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id field',
                'resolve' => function($root)
                {
                    // The resolve method is not mandatory but for the sake of the example.
                    // Here we return the value of the id from our eloquent model. $root
                    // is a User model. We don't need to think about the global id
                    // it will be generated from this id and the type name
                    return $root->id;
                }
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email field'
            ],
            'photos' => [
                'type' => GraphQL::type('PhotosConnection'),
                'description' => 'The photos of the user'
            ]
        ];
    }

    // We get the eloquent model from the id
    public function resolveById($id)
    {
        return User::find($id);
    }
}
