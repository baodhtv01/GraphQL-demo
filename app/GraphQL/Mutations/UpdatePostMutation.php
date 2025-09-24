<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Post;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updatePost',
        'description' => 'A mutation to update a post'
    ];

    public function type(): Type
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the post',
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                'description' => 'The title of the post',
            ],
            'content' => [
                'name' => 'content',
                'type' => Type::string(),
                'description' => 'The content of the post',
            ],
            'published' => [
                'name' => 'published',
                'type' => Type::boolean(),
                'description' => 'Whether the post is published',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $post = Post::findOrFail($args['id']);

        $updateData = [];

        if (isset($args['title'])) {
            $updateData['title'] = $args['title'];
        }

        if (isset($args['content'])) {
            $updateData['content'] = $args['content'];
        }

        if (isset($args['published'])) {
            $updateData['published'] = $args['published'];
        }

        $post->update($updateData);

        return $post;
    }
}
