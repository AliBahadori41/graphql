<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Authentication;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class Register extends Mutation
{
    protected $attributes = [
        'name' => 'register',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('LoginType');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
            ],
            'email' => [
                'type' => Type::string(),
                'rules' => ["required","string", "email", "unique:users"]
            ],
            'password' => [
                'type' => Type::string(),
                'rules' => ["required", "string", "min:8"]
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = User::create($args);

        $token = $user->createToken('my-app')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}
