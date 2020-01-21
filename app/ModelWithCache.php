<?php

namespace App;

abstract class ModelWithCache extends \Illuminate\Database\Eloquent\Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function (ModelWithCache $model) {
            static::flushCache($model);
        });

        static::updated(function (ModelWithCache $model) {
            static::flushCache($model);
        });

        static::deleted(function (ModelWithCache $model) {
            static::flushCache($model);
        });
    }

    abstract static protected function flushCache(self $model = null);
}
