<?php

namespace App;

use App\Service\TaggedCache;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['owner_id', 'body'];

    protected static function boot()
    {
        parent::boot();

        // Cache
        static::created(function (Comment $comment) {
            self::flushCache($comment);
        });

        static::updated(function (Comment $comment) {
            self::flushCache($comment);
        });

        static::deleted(function (Comment $comment) {
            self::flushCache($comment);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    private static function flushCache(Comment $comment)
    {
        $commentable = $comment->commentable;

        if ($commentable instanceof Post) {
            TaggedCache::post($commentable)->flush(false);
        } elseif ($commentable instanceof News) {
            TaggedCache::aNews($commentable)->flush(false);
        }
    }
}
