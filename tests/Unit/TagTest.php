<?php

namespace Tests\Unit;

use App\Service\TaggedCache;
use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function a_tag_can_have_posts()
    {
        // Arrange
        $tag = factory(Tag::class)->create();
        $posts = factory(\App\Post::class, 2)->create();

        // Act
        $tag->posts()->attach($posts);

        // Assert
        $this->assertEquals($posts->first()->title, $tag->posts->first()->title);
        $this->assertEquals($posts->last()->title, $tag->posts->last()->title);
    }

    /** @test */
    public function a_tag_can_have_news()
    {
        // Arrange
        $tag = factory(Tag::class)->create();
        $news = factory(\App\News::class, 2)->create();

        // Act
        $tag->news()->attach($news);

        // Assert
        $this->assertEquals($news->first()->title, $tag->news->first()->title);
        $this->assertEquals($news->last()->title, $tag->news->last()->title);
    }

    /** @test */
    public function method_tagsCloud_returns_tags()
    {
        // Arrange
        $tagsNumber = 2;
        factory(Tag::class, $tagsNumber)->create()->each(function (Tag $tag) {
            $tag->posts()->attach(factory(\App\Post::class)->create());
        });

        // Act
        $tagsCloud = Tag::tagsCloud();

        // Assert
        $this->assertEquals($tagsCloud->count(), $tagsNumber);
    }

    /** @test */
    public function method_tags_cloud_returns_only_tags_attached_to_posts_or_news()
    {
        // Arrange
        $emptyTags = factory(Tag::class, 2)->create();
        $tagsWithPosts = factory(Tag::class, 2)->create();
        $tagsWithNews = factory(Tag::class, 2)->create();
        $tagsWithPostsAndNews = factory(Tag::class, 2)->create();
        $post = factory(\App\Post::class)->create()->tags()->attach($tagsWithPosts->merge($tagsWithPostsAndNews));
        $news = factory(\App\News::class)->create()->tags()->attach($tagsWithNews->merge($tagsWithPostsAndNews));

        // Act
        $tagsCloud = Tag::tagsCloud();

        // Assert
        $this->assertEquals($tagsCloud->count(), 6);
    }

    /** @test */
    public function creating_tag_flushes_tags_cache()
    {
        // Arrange
        TaggedCache::tags()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        factory(Tag::class)->create();

        // Assert
        $this->assertNull(TaggedCache::tags()->getCache()->get('cache'));
    }

    /** @test */
    public function updating_tag_flushes_tags_cache()
    {
        // Arrange
        $tag = factory(Tag::class)->create();
        TaggedCache::tags()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $tag->update(['name' => $this->faker->words(3, true)]);

        // Assert
        $this->assertNull(TaggedCache::tags()->getCache()->get('cache'));
    }

    /** @test */
    public function deleting_tag_flushes_tags_cache()
    {
        // Arrange
        $tag = factory(Tag::class)->create();
        TaggedCache::tags()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $tag->delete();

        // Assert
        $this->assertNull(TaggedCache::tags()->getCache()->get('cache'));
    }

    /** @test */
    public function syncing_with_attached_tags_flushes_tags_cache()
    {
        // Arrange
        $post = factory(\App\Post::class)->create();
        $tag = factory(Tag::class)->create(['name' => $this->faker->words(3, true)]);
        TaggedCache::tags()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        Tag::sync($post, [$tag->name]);

        // Assert
        $this->assertNull(TaggedCache::tags()->getCache()->get('cache'));
    }

    /** @test */
    public function syncing_with_detached_tags_flushes_tags_cache()
    {
        // Arrange
        $post = factory(\App\Post::class)->create();
        $tag = factory(Tag::class)->create(['name' => $this->faker->words(3, true)]);
        $post->tags()->attach($tag);
        TaggedCache::tags()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        Tag::sync($post, []);

        // Assert
        $this->assertNull(TaggedCache::tags()->getCache()->get('cache'));
    }

    /** @test */
    public function syncing_tags_without_changes__does_not_flush_tags_cache()
    {
        // Arrange
        $post = factory(\App\Post::class)->create();
        $tag = factory(Tag::class)->create(['name' => $this->faker->words(3, true)]);
        $post->tags()->attach($tag);
        $cache = TaggedCache::tags()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        Tag::sync($post, [$tag->name]);

        // Assert
        $this->assertEquals($cache, TaggedCache::tags()->getCache()->get('cache'));
    }
}
