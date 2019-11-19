<?php

namespace App;

class Post extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['owner_id', 'slug', 'title', 'abstract', 'body', 'is_active'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }

}
