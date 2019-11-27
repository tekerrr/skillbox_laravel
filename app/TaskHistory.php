<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Task::class);
    }
}
