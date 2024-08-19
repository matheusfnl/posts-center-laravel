<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostVote;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        foreach ($posts as $post) {
            $numVotes = rand(1, 200);
            $shuffledUsers = $users->shuffle()->take($numVotes);
            $voteTypeSeed = rand(0, 1);

            foreach ($shuffledUsers as $user) {
                if ($voteTypeSeed === 0) {
                    $voteType = rand(1, 100) <= 75 ? 'downvote' : 'upvote';
                } else {
                    $voteType = rand(1, 100) <= 75 ? 'upvote' : 'downvote';
                }

                PostVote::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'vote_type' => $voteType,
                ]);
            }
        }
    }
}
