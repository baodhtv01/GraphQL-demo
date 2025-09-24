<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Post;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createPost',
        'description' => 'A mutation to create a new post'
    ];

    public function type(): Type
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the post',
            ],
            'content' => [
                'name' => 'content',
                'type' => Type::nonNull(Type::string()),
                'description' => 'The content of the post',
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the user who creates the post',
            ],
            'published' => [
                'name' => 'published',
                'type' => Type::boolean(),
                'description' => 'Whether the post is published',
                'defaultValue' => false,
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Post::create([
            'title' => $args['title'],
            'content' => $args['content'],
            'user_id' => $args['user_id'],
            'published' => $args['published'],
        ]);
    }
}
