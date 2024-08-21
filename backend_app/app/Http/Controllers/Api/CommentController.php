<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $postId)
    {
        return Comment::where('post_id', (int) $postId)->latest()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $postId)
    {
        $comment = Comment::create([
            ...$request->validate([
                'description' =>  'required|string',
            ]),
            'user_id' => $request->user()->id,
            'post_id' => (int) $postId,
        ]);

        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $postId, Comment $comment)
    {
        $this->authorizeUser($comment, $request->user());

        $comment->update($request->validate([
            'description' =>  'required|string',
        ]));

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $postId, Comment $comment)
    {
        $this->authorizeUser($comment, $request->user());

        $comment->delete();

        return response(status: 204);
    }

    private function authorizeUser(Comment $comment, User $user): void
    {
        if ($comment->user_id !== $user->id) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
        }
    }
}
