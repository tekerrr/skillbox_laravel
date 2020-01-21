<?php

namespace App;

use App\Service\TaggedCache;

class Comment extends ModelWithCache
{
    protected $fillable = ['owner_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    protected static function flushCache(ModelWithCache $comment = null)
    {
        $commentable = $comment->commentable;

        if ($commentable instanceof Post) {
            TaggedCache::post($commentable)->flush();
        } elseif ($commentable instanceof News) {
            TaggedCache::aNews($commentable)->flush();
        }
    }
}
