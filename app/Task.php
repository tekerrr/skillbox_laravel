<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'body', 'owner_id'];

    protected $dispatchesEvents = [
        'created' => \App\Events\TaskCreated::class
    ];

    protected $attributes = [
        'type' => 'new',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('onlyNew', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('type', 'new');
        });
    }

    protected $appends = [
        'double_type',
    ];

    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }

    public function getDoubleTypeAttribute()
    {
        return str_repeat($this->type, 2);
    }


    public function getRouteKeyName()
    {
        return 'id';
    }

    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeNew($query)
    {
        return $query->ofType('new');
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
