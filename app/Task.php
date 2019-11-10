<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'body', 'owner_id'];

    protected $dispatchesEvents = [
        'created' => \App\Events\TaskCreated::class
    ];

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::created(function ($task) {
//            \Mail::to($task->owner->email)->send(
//                new TaskCreated($task)
//            );
//        });
//    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function addStep(array $attributes)
    {
        return $this->steps()->create($attributes);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function isCompleted(): bool
    {
        return (bool) $this->completed;
    }

    public function isNotCompleted(): bool
    {
        return ! $this->isCompleted();
    }

    public function newCollection(array $models = [])
    {
        return new class($models) extends Collection {
            public function allCompleted()
            {
                return $this->filter->isCompleted();
            }

            public function allNotCompleted()
            {
                return $this->filter->isNotCompleted();
            }
        };
    }


}
