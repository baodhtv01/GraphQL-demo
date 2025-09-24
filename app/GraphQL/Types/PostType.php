<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PostType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Post',
        'description' => 'A post',
        'model' => Post::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the post',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of post',
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The content of post',
            ],
            'published' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Whether the post is published',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the user who created the post',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'When the post was created',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'When the post was last updated',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'The user who created the post',
            ],
        ];
    }
}
