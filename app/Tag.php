<?php

namespace App;

use App\Service\TaggedCache;

class Tag extends ModelWithCache
{
    protected $fillable = ['name'];

    public static function sync($taggable, $newTags)
    {
        $currentTags = $taggable->tags->keyBy('name');
        $newTags = collect($newTags)->keyBy(function ($item) { return $item; });

        $attachedTags = $newTags->diffKeys($currentTags);
        $detachedTags = $currentTags->diffKeys($newTags);

        $taggable->tags()->attach(Tag::getIds($attachedTags));
        $taggable->tags()->detach(Tag::getIds($detachedTags));

        if ($attachedTags->isNotEmpty() || $detachedTags->isNotEmpty()) {
            self::flushCache();
        }
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

    protected static function flushCache(ModelWithCache $tag = null)
    {
        TaggedCache::tags()->flush();
    }
}
