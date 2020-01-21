<?php

namespace Tests\Unit;

use App\Service\TaggedCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaggedCacheTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function method_get_tags_return_tags()
    {
        // Arrange
        $tags = $this->faker->words();
        $cache = new TaggedCache(...$tags);

        // Act
        $response = $cache->getTags();

        // Assert
        $this->assertEquals($tags, $response);
    }

    /** @test */
    public function method_with_adds_tag_to_object_tags()
    {
        // Arrange
        $ownTags = $this->faker->words();
        $cache = new TaggedCache(...$ownTags);
        $newTags = $this->faker->words();

        // Act
        $cache->with(new TaggedCache(...$newTags));

        // Assert
        $this->assertEquals(array_merge($ownTags, $newTags), $cache->getTags());
    }

    /** @test */
    public function method_get_cache_returns_tagged_cache()
    {
        // Arrange
        $cache = new TaggedCache(...$this->faker->words());

        // Act
        $response = $cache->getCache();

        // Assert
        $this->assertEquals(\Illuminate\Cache\TaggedCache::class, get_class($response));
    }

    /** @test */
    public function method_remember_sets_cache()
    {
        // Arrange
        $tags = $this->faker->words();
        $cache = new TaggedCache(...$tags);

        // Act
        $response = $cache->remember('cache', function () {
            return $this->faker->sentence;
        });

        // Assert
        $this->assertEquals($response, \Cache::tags($tags)->get('cache'));
    }

    /** @test */
    public function method_flush_deletes_onlu_current_cache()
    {
        // Arrange
        $firstTag = $this->faker->unique()->word;
        $firstCache = (new TaggedCache($firstTag));
        $firstCache->remember('cache', function () {
            return $this->faker->sentence;
        });

        $secondTag = $this->faker->unique()->word;
        $secondCache = (new TaggedCache($secondTag))->remember('cache', function () {
            return $this->faker->sentence;
        });

        // Act
        $firstCache->flush();

        // Assert
        $this->assertNull(\Cache::tags($firstTag)->get('cache'));
        $this->assertEquals($secondCache, \Cache::tags($secondTag)->get('cache'));
    }

    /** @test */
    public function static_method_post_can_get_route_key_from_model()
    {
        // Arrange
        $post = factory(\App\Post::class)->create();

        // Act
        $firstCache = TaggedCache::post($post->slug);
        $secondCache = TaggedCache::post($post);

        // Assert
        $this->assertEquals('post|' . $post->slug, $firstCache->getTags()[0]);
        $this->assertEquals('post|' . $post->slug, $secondCache->getTags()[0]);
    }

    /** @test */
    public function static_method_a_news_can_get_route_key_from_model()
    {
        // Arrange
        $news = factory(\App\News::class)->create();

        // Act
        $firstCache = TaggedCache::aNews($news->slug);
        $secondCache = TaggedCache::aNews($news);

        // Assert
        $this->assertEquals('a_news|' . $news->slug, $firstCache->getTags()[0]);
        $this->assertEquals('a_news|' . $news->slug, $secondCache->getTags()[0]);
    }
}
