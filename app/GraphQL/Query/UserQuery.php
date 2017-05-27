<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query as BaseQuery;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class UserQuery extends BaseQuery
{
    protected $attributes = [
        'name' => 'UserQuery',
        'description' => 'A query'
    ];

    protected function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'description' => 'The user id'
            ]
        ];
    }

    protected function type()
    {
        //This is the type we've created the step before
        return GraphQL::type('User');
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        //Take the arguments and get a user from an eloquent model
        $user = User::find($args['id']);
        return $user;
    }
}
