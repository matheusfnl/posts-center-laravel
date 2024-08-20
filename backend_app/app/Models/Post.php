<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postVotes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_votes')->withPivot('vote_type');
    }
}
