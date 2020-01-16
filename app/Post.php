<?php

namespace App;

use App\Service\TaggedCache;

class Post extends \Illuminate\Database\Eloquent\Model
{
    use CanBeActivated;
    use CanBeBinding;

    protected $fillable = ['owner_id', 'slug', 'title', 'abstract', 'body', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();

        static::updating(function (Post $post) {
            $post->history()->attach(auth()->id(), [
                'after' => json_encode($after = $post->getDirty()),
                'before' => json_encode(\Arr::only($post->getOriginal(), array_keys($after))),
            ]);
        });

        static::deleting(function (Post $post) {
            $post->comments()->delete();
        });

        // Cache
        static::created(function () {
            self::flushCache();
        });

        static::updated(function (Post $post) {
            self::flushCache($post);
        });

        static::deleted(function (Post $post) {
            self::flushCache($post);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->orderBy('name');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function history()
    {
        return $this
            ->belongsToMany(User::class, 'post_histories')
            ->withPivot(['before', 'after'])
            ->withTimestamps()
            ->orderByDesc('pivot_created_at')
        ;
    }

    private static function flushCache(Post $post = null)
    {
        $cache = $post ? TaggedCache::post($post) : TaggedCache::posts();
        $cache->flush();
    }
}
