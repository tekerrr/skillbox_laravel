<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $guarded = [];

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
}
