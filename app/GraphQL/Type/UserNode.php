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
            /*'photos' => [
                'type' => GraphQL::type('PhotosConnection'),
                'description' => 'The photos of the user'
            ],*/
            'name' => [
                'type' => Type::string(),
                'description' => "The name of the user"
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email field'
            ],
            'password' => [
                'type' => Type::string(),
                'description' => "The password of the user"
            ],
            'remember_token' => [
                'type' => Type::string(),
                'description' => "A token to authenticate the user with"
            ]
        ];
    }

    // We get the eloquent model from the id
    public function resolveById($id)
    {
        return User::find($id);
    }
}
