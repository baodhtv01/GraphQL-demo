<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUser',
        'description' => 'A mutation to update a user'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the user',
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                'description' => 'The name of the user',
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'description' => 'The email of the user',
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'description' => 'The password of the user',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = User::findOrFail($args['id']);

        $updateData = [];

        if (isset($args['name'])) {
            $updateData['name'] = $args['name'];
        }

        if (isset($args['email'])) {
            $updateData['email'] = $args['email'];
        }

        if (isset($args['password'])) {
            $updateData['password'] = Hash::make($args['password']);
        }

        $user->update($updateData);

        return $user;
    }
}
