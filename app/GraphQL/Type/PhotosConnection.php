<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Relay\Support\ConnectionType as BaseConnectionType;
use GraphQL;

class PhotosConnection extends BaseConnectionType
{
    protected $attributes = [
        'name' => 'PhotosConnection',
        'description' => 'A relay photos connection'
    ];

    protected function edgeType()
    {
        // Add the edge type here
        return GraphQL::type('Photo');
    }
}
