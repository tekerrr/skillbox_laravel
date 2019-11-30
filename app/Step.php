<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $guarded = [];

    protected $touches = ['task'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function complete(bool $completed = true)
    {
        $this->update(['completed' => $completed]);
    }

    public function incomplete(bool $completed = true)
    {
        $this->complete(false);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
