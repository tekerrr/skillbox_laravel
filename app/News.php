<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use CanBeActivated;

    protected $fillable = ['slug', 'title', 'abstract', 'body', 'is_active'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
