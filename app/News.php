<?php

namespace App;

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
            \Cache::tags('news')->flush();
        });

        static::updated(function (News $news) {
            \Cache::tags(['news', 'a_news|' . $news->getOriginal('slug')])->flush();
        });

        static::deleted(function (News $news) {
            \Cache::tags(['news', 'a_news|' . $news->getOriginal('slug')])->flush();
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
