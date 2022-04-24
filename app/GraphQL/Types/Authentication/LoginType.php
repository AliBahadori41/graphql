<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Authentication;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoginType extends GraphQLType
{
    protected $attributes = [
        'name' => 'LoginType',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'token' => [
                'type' => Type::string(),
            ],
            'user' => [
                'type' => GraphQL::type('UsersType')
            ]
        ];
    }
}
