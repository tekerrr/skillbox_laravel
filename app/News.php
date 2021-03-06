<?php

namespace App;

use App\Service\TaggedCache;

class News extends ModelWithCache
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
    }

    protected static function flushCache(ModelWithCache $aNews = null)
    {
        TaggedCache::aNews($aNews)->with(TaggedCache::news())->flush();
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
}
