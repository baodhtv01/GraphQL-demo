<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
        'description' => 'A query to get all users'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit the number of users returned',
                'defaultValue' => 10,
            ],
            'published_posts_only' => [
                'name' => 'published_posts_only',
                'type' => Type::boolean(),
                'description' => 'Include only users with published posts',
                'defaultValue' => false,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = User::query();

        if ($args['published_posts_only']) {
            $query->whereHas('posts', function ($query) {
                $query->where('published', true);
            });
        }

        return $query->with('posts')->limit($args['limit'])->get();
    }
}
