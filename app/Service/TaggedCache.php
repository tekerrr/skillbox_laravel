<?php

namespace App\Service;

use Closure;
use Illuminate\Database\Eloquent\Model;

class TaggedCache
{
    protected static $tagDelimiter = '|';

    protected $basicTag;
    protected $additionalRememberTags = [];
    protected $additionalFlushTags = [];

    public static function users(): self
    {
        return new self('users');
    }

    public static function tags(): self
    {
        return new self('tags');
    }

    public static function posts(): self
    {
        return (new self('posts'))
            ->addRememberCacheTag(self::tags());
    }

    public static function news(): self
    {
        return (new self('news'))
            ->addRememberCacheTag(self::tags());
    }

    /**
     * @param Model|array $key
     * @return static
     */
    public static function post($key): self
    {
        return (new self('post'. self::$tagDelimiter . self::getModelKey($key)))
            ->addRememberCacheTag(self::tags())
            ->addRememberCacheTag(self::users())
            ->addFlushCacheTag(self::posts());
    }

    /**
     * @param Model|array $key
     * @return static
     */
    public static function aNews($key): self
    {
        return (new self('a_news'. self::$tagDelimiter . self::getModelKey($key)))
            ->addRememberCacheTag(self::tags())
            ->addRememberCacheTag(self::users())
            ->addFlushCacheTag(self::news());
    }

    /**
     * @param Model|array $key
     * @return string
     */
    protected static function getModelKey($key): string
    {
        if (is_subclass_of($key, Model::class)) {
            return $key->getOriginal($key->getRouteKeyName());
        }

        return $key;
    }

    public function __construct($tag)
    {
        $this->basicTag = $tag;
    }

    public function getBasicTag(): string
    {
        return $this->basicTag;
    }

    public function addRememberCacheTag(self $cache)
    {
        $this->additionalRememberTags[] = $cache->getBasicTag();

        return $this;
    }

    public function addFlushCacheTag(self $cache)
    {
        $this->additionalRememberTags[] = $cache->getBasicTag();

        return $this;
    }

    public function remember($key, Closure $callback, $ttl = null)
    {
        return $this->getCacheForRemember()->remember($key, $ttl ?? $this->getTtl(), $callback);
    }

    public function flush($withAdditionalTags = true)
    {
        $this->getCacheForFlush($withAdditionalTags)->flush();
    }

    protected function getCacheForRemember()
    {
        return \Cache::tags(array_merge([$this->basicTag], $this->additionalRememberTags));
    }

    protected function getCacheForFlush($withAdditionalTags = true)
    {
        return \Cache::tags(array_merge([$this->basicTag], $withAdditionalTags ? $this->additionalFlushTags : []));
    }

    protected function getTtl()
    {
        return config('cache.ttl');
    }
}
