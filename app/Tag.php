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
        return $this->morphedByMany(Task::class, 'taggable');
    }

    public function steps()
    {
        return $this->morphedByMany(Step::class, 'taggable');
    }

    public static function tagsCloud()
    {
        return (new static)->has('tasks')->get();
    }
}
