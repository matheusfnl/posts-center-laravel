<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];
    protected $appends = ['vote', 'upvotes_qtd', 'downvotes_qtd'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postVotes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_votes')->withPivot('vote_type');
    }

    public function getVoteAttribute() {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user_vote = $this->postVotes()->where('user_id', $user->id)->first();

            return $user_vote ? $user_vote->pivot->vote_type : null;
        }

        return null;
    }

    public function getUpvotesQtdAttribute()
    {
        return $this->postVotes()->where('vote_type', 'upvote')->count();
    }

    public function getDownvotesQtdAttribute()
    {
        return $this->postVotes()->where('vote_type', 'downvote')->count();
    }
}
