<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query as BaseQuery;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class MovieQuery extends BaseQuery
{
    protected $attributes = [
        'name' => 'MovieQuery',
        'description' => 'A query'
    ];

    protected function type()
    {
        return Type::listOf(Type::string());
    }

    protected function args()
    {
        return [
            
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return [];
    }
}
