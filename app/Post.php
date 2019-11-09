<?php

namespace App;

class Post extends Model
{
    protected $fillable = ['owner_id', 'slug', 'title', 'abstract', 'body', 'published'];

    protected $dispatchesEvents = [
        'created' => \App\Events\PostCreated::class,
        'updated' => \App\Events\PostUpdated::class,
        'deleted' => \App\Events\PostDeleted::class,
    ];

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
