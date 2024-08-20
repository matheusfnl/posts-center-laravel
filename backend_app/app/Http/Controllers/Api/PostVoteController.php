<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Http\Request;

class PostVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request, string $postId)
    {
        $post_vote = PostVote::create([
            ...$request->validate([
                'vote_type' => ['required', 'in:' . implode(',', PostVote::VOTE_TYPES)],
            ]),
            'user_id' => $request->user()->id,
            'post_id' => (int) $postId,
        ]);

        return $post_vote;
    }

    public function update(Request $request, string $postId, PostVote $vote)
    {
        $vote->update($request->validate([
            'vote_type' => ['required', 'in:' . implode(',', PostVote::VOTE_TYPES)],
        ]));

        return $vote;
    }

    public function destroy(string $postId, PostVote $vote)
    {
        $vote->delete();

        return response(status: 204);
    }
}
