<?php

namespace App;

class News extends CachedModel
{
    use CanBeActivated;
    use CanBeBinding;

    protected $fillable = ['slug', 'title', 'abstract', 'body', 'is_active'];

    protected $singularCacheTag = 'a_news';
    protected $pluralCacheTag = 'news';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (News $news) {
            $news->comments()->delete();
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
}
