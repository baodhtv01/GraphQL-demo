<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with posts
        User::factory(5)->create()->each(function ($user) {
            Post::factory(3)->create(['user_id' => $user->id]);
        });

        // Create a test user
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create some posts for the test user
        Post::factory(5)->create(['user_id' => $testUser->id]);
    }
}
