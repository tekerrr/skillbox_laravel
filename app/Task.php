<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'body', 'owner_id'];

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
}
