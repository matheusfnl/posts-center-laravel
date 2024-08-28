<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];
    protected $appends = ['vote', 'upvotes_qtd', 'downvotes_qtd', 'comments_qtd'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postVotes(): HasMany
    {
        return $this->hasMany(PostVote::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getVoteAttribute() {
        $user = Auth::guard('api')->user();

        if ($user) {
            $userVote = $this->postVotes()->where('user_id', $user->id)->first();

            return $userVote;
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

    public function getCommentsQtdAttribute()
    {
        return $this->comments()->count();
    }
}
