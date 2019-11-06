<?php

namespace App;

class Post extends Model
{
    protected $fillable = ['slug', 'title', 'abstract', 'body', 'published'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }

}
