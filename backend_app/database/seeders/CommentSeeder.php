<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostVote;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $totalVotes = PostVote::all()->where('post_id', $post->id)->count();
            $randomNumber = mt_rand(100, 250) / 1000;
            $numComments = (int) round($totalVotes * $randomNumber);

            for ($i = 0; $i < $numComments; $i++) {
                $user = User::inRandomOrder()->first();

                Comment::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
