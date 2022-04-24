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

class Login extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('LoginType');
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::string(),
                'rules' => ["required", "string", "email", "exists:users,email"]
            ],
            'password' => [
                'type' => Type::string(),
                'rules' => ["required"]
            ],
            'device' => [
                'type' => Type::string(),
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        $user = User::where('email', $args['email'])->first();

        $token = $user->createToken($args['device'])->plainTextToken;

        return [
            'token' => $token,
        ];
    }
}
