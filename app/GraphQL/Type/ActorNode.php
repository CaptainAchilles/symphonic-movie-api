<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Relay\Support\NodeType as BaseNodeType;
use GraphQL;

class ActorNode extends BaseNodeType
{
    protected $attributes = [
        'name' => 'ActorNode',
        'description' => 'A relay node type'
    ];

    protected function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id())
            ]
        ];
    }
    
    public function resolveById($id)
    {
        // Get a node from an id
    }
}
