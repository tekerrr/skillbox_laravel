<?php

namespace App;

class Post extends \Illuminate\Database\Eloquent\Model
{
    use CanBeActivated;

    protected $fillable = ['owner_id', 'slug', 'title', 'abstract', 'body', 'is_active'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->orderBy('name');
    }

}
