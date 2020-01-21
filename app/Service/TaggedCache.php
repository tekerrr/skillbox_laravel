<?php

namespace App\Service;

use Closure;
use Illuminate\Database\Eloquent\Model;

class TaggedCache
{
    protected static $tagDelimiter = '|';
    protected $tags;

    public static function users(): self
    {
        return new self('users');
    }

    public static function tags(): self
    {
        return new self('tags');
    }

    public static function feedbacks(): self
    {
        return new self('feedbacks');
    }

    public static function comments(): self
    {
        return new self('comments');
    }

    public static function posts(): self
    {
        return (new self('posts'));
    }

    public static function news(): self
    {
        return (new self('news'));
    }

    /**
     * @param Model|array $key
     * @return static
     */
    public static function post($key): self
    {
        return (new self('post'. self::$tagDelimiter . self::getModelKey($key)));
    }

    /**
     * @param Model|array $key
     * @return static
     */
    public static function aNews($key): self
    {
        return (new self('a_news'. self::$tagDelimiter . self::getModelKey($key)));
    }

    /**
     * @param Model|array $key
     * @return string
     */
    protected static function getModelKey($key): string
    {
        if (is_subclass_of($key, Model::class)) {
            return $key->getOriginal($key->getRouteKeyName()) ?? $key->getAttribute($key->getRouteKeyName());
        }

        return $key;
    }

    public function __construct(...$tags)
    {
        $this->tags = $tags;
    }

    public function with(TaggedCache $cache)
    {
        $this->tags = array_merge($this->tags, $cache->getTags());

        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function remember($key, Closure $callback, $ttl = null)
    {
        return $this->getCache()->remember($key, $ttl ?? $this->getTtl(), $callback);
    }

    public function flush()
    {
        $this->getCache()->flush();
    }

    protected function getCache(): \Illuminate\Cache\TaggedCache
    {
        return \Cache::tags($this->tags);
    }

    protected function getTtl()
    {
        return config('cache.ttl');
    }
}
