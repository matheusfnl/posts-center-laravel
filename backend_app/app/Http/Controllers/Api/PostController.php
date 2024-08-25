<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'getPostsByUser']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->query('sort');
        $query = Post::query()->withCount([
            'postVotes as upvotes_qtd' => fn($query) => $query->where('vote_type', 'upvote'),
            'postVotes as downvotes_qtd' => fn($query) => $query->where('vote_type', 'downvote'),
        ]);

        switch ($sort) {
            case 'positive':
                $query->orderByRaw('upvotes_qtd - downvotes_qtd DESC');
                break;
            case 'negative':
                $query->orderByRaw('downvotes_qtd - upvotes_qtd DESC');
                break;
            case 'popular':
                $query->orderByRaw('downvotes_qtd - upvotes_qtd DESC');
                break;
            case 'answered':
                $query->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = Post::create([
            ...$request->validate([
                'title' => 'required|string|max:255',
                'description' =>  'required|string|min:10',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorizeUser($post, $request->user());

        $post->update($request->validate([
            'title' => 'required|string|max:255',
            'description' =>  'required|string|min:10',
        ]));

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $this->authorizeUser($post, $request->user());

        $post->delete();

        return response(status: 204);
    }

    public function getPostsByUser(User $user)
    {
        return Post::where('user_id', '=', $user->id)
            ->latest()
            ->paginate();
    }

    private function authorizeUser(Post $post, User $user): void
    {
        if ($post->user_id !== $user->id) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
        }
    }
}
