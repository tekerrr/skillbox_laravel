<?php

namespace App;

use Illuminate\Support\Collection;

class Tag extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        // Cache
        static::created(function () {
            \Cache::tags('tags')->flush();
        });

        static::updated(function (Tag $tag) {
            \Cache::tags(['tags', 'posts_tag|' . $tag->name, 'news_tag|' . $tag->name])->flush();
        });

        static::deleted(function (Tag $tag) {
            \Cache::tags(['tags', 'posts_tag|' . $tag->name, 'news_tag|' . $tag->name])->flush();
        });
    }

    public static function sync($taggable, $newTags)
    {
        $currentTags = $taggable->tags->keyBy('name');
        $newTags = collect($newTags)->keyBy(function ($item) { return $item; });

        $taggable->tags()->attach(Tag::getIds($newTags->diffKeys($currentTags)));
        $taggable->tags()->detach(Tag::getIds($currentTags->diffKeys($newTags)));
    }

    protected static function getIds($names)
    {
        return collect($names)->map(function ($name) {
            return Tag::firstOrCreate(['name' => $name])->id;
        });
    }

    public static function tagsCloud()
    {
        return (new static)->has('posts')->orHas('news')->orderBy('name')->get();
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class, 'taggable');
    }
}
