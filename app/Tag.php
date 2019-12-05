<?php

namespace App;

class Tag extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name'];

    public static function getIds($names)
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
