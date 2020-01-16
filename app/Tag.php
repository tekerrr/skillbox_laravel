<?php

namespace App;

use App\Service\TaggedCache;

class Tag extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        // Cache
        static::created(function () {
            self::flushCache();
        });

        static::updated(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }

    public static function sync($taggable, $newTags)
    {
        $currentTags = $taggable->tags->keyBy('name');
        $newTags = collect($newTags)->keyBy(function ($item) { return $item; });

        $taggable->tags()->attach(Tag::getIds($newTags->diffKeys($currentTags)));
        $taggable->tags()->detach(Tag::getIds($currentTags->diffKeys($newTags)));

        self::flushCache();
    }

    protected static function getIds($names)
    {
        return collect($names)->map(function ($value, $key) {
            return Tag::firstOrCreate(['name' => $key])->id;
        })->values();
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

    private static function flushCache()
    {
        TaggedCache::tags()->flush();
    }
}
