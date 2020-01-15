<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CachedModel extends Model
{
    protected $singularCacheTag = 'model';
    protected $pluralCacheTag = 'models';
    protected $cacheTagDelimiter = '|';

    protected static function boot()
    {
        parent::boot();

        static::created(function (self $model) {
            \Cache::tags($model->pluralCacheTag)->flush();
        });

        static::updated(function (self $model) {
            \Cache::tags([
                $model->pluralCacheTag,
                $model->singularCacheTag . $model->cacheTagDelimiter . $model->getOriginal('slug')
            ])->flush();
        });

        static::deleted(function (self $model) {
            \Cache::tags([
                $model->pluralCacheTag,
                $model->singularCacheTag . $model->cacheTagDelimiter . $model->getOriginal('slug')
            ])->flush();
        });
    }
}
