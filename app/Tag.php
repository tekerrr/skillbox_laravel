<?php

namespace App;

class Tag extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['name'];

    public static function tagsCloud()
    {
        return (new static)->has('posts')->orderBy('name')->get();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
