<?php

namespace App;

use App\Service\TaggedCache;

class News extends \Illuminate\Database\Eloquent\Model
{
    use CanBeActivated;
    use CanBeBinding;

    protected $fillable = ['slug', 'title', 'abstract', 'body', 'is_active'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (News $news) {
            $news->comments()->delete();
        });

        // Cache
        static::created(function () {
            TaggedCache::news()->flush();
        });

        static::updated(function (News $news) {
            TaggedCache::aNews($news)->flush();
        });

        static::deleted(function (News $news) {
            TaggedCache::aNews($news)->flush();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->orderBy('name');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    private static function flushCache(News $news = null)
    {
        $cache = $news ? TaggedCache::aNews($news) : TaggedCache::news();
        $cache->flush();
    }
}
