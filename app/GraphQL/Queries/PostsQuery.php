<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Post;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PostsQuery extends Query
{
    protected $attributes = [
        'name' => 'posts',
        'description' => 'A query to get all posts'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Post'));
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit the number of posts returned',
                'defaultValue' => 10,
            ],
            'published' => [
                'name' => 'published',
                'type' => Type::boolean(),
                'description' => 'Filter by published status',
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::id(),
                'description' => 'Filter by user id',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = Post::query();

        if (isset($args['published'])) {
            $query->where('published', $args['published']);
        }

        if (isset($args['user_id'])) {
            $query->where('user_id', $args['user_id']);
        }

        return $query->with('user')->limit($args['limit'])->get();
    }
}
