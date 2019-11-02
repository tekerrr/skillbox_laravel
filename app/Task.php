<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'body'];

    public function getRouteKeyName()
    {
        return 'id';
    }


    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }
}
