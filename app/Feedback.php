<?php

namespace App;

use App\Service\TaggedCache;

class Feedback extends ModelWithCache
{
    protected $fillable = ['email', 'body'];

    static protected function flushCache(ModelWithCache $feedback = null)
    {
        TaggedCache::feedbacks()->flush();
    }
}
