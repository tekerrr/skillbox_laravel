<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public static function tagsCloud()
    {
        return (new static)->has('tasks')->get();
    }
}
