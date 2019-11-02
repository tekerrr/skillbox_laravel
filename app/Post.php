<?php

namespace App;

class Post extends \Illuminate\Database\Eloquent\Model
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
}
