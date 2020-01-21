<?php

namespace Tests\Unit;

use App\News;
use App\Service\TaggedCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function the_class_is_using_can_be_activated_trait_correctly()
    {
        // Arrange
        $elements = factory(News::class, 2)->create(['is_active' => false]);

        // Act
        $elements->first()->activate();

        // Assert
        $this->assertTrue($elements->first()->isActive());
        $this->assertFalse($elements->last()->isActive());
    }

    /** @test */
    public function the_class_is_using_can_be_binding_trait_correctly()
    {
        // Arrange
        $post = factory(News::class)->create();

        // Act
        $response = News::getBindingModel($post->slug);

        // Assert
        $this->assertEquals($post->title, $response->title);
    }

    /** @test */
    public function a_news_can_have_tags()
    {
        // Arrange
        $news = factory(News::class)->create();
        $tags = factory(\App\Tag::class, 2)->create();

        // Act
        $news->tags()->attach($tags);

        // Assert
        $this->assertTrue($news->tags()->where('name', $tags->first()->name)->exists());
        $this->assertTrue($news->tags()->where('name', $tags->last()->name)->exists());
    }

    /** @test */
    public function news_tags_are_selected_in_alphabetical_order()
    {
        // Arrange
        $news = factory(News::class)->create();
        $news->tags()->saveMany([
            factory(\App\Tag::class)->make(['name' => 'ZZZ']),
            factory(\App\Tag::class)->make(['name' => 'AAA']),
            factory(\App\Tag::class)->make(['name' => 'BBB']),
        ]);

        // Act
        $tags = $news->tags;

        // Assert
        $this->assertEquals('AAA', $tags->first()->name);
    }

    /** @test */
    public function a_news_can_have_comments()
    {
        // Arrange
        $news = factory(News::class)->create();
        $comments = factory(\App\Comment::class, 2)->state('withoutCommentable')->make();

        // Act
        $news->comments()->saveMany($comments);

        // Assert
        $this->assertEquals($news->comments->first()->body, $comments->first()->body);
        $this->assertEquals($news->comments->last()->body, $comments->last()->body);
    }

    /** @test */
    public function comments_are_deleted_when_the_post_is_deleted()
    {
        // Arrange
        factory(\App\Comment::class, 2)->create();
        $news = factory(News::class)->create();
        $comment = factory(\App\Comment::class)->state('withoutCommentable')->make();
        $news->comments()->save($comment);

        // Act
        $news->delete();

        // Assert
        $this->assertEquals(2, \App\Comment::count());
    }

    /** @test */
    public function creating_news_flushes_news_cache()
    {
        // Arrange
        TaggedCache::news()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        factory(News::class)->create();

        // Assert
        $this->assertNull(TaggedCache::news()->getCache()->get('cache'));
    }

    /** @test */
    public function updating_news_flushes_news_cache()
    {
        // Arrange
        $news = factory(News::class)->create();
        TaggedCache::news()->remember('cache', function () {
            return $this->faker->words(3, true);
        });
        TaggedCache::aNews($news)->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $news->update(['title' => $this->faker->words(3, true)]);

        // Assert
        $this->assertNull(TaggedCache::news()->getCache()->get('cache'));
        $this->assertNull(TaggedCache::aNews($news->slug)->getCache()->get('cache'));
    }

    /** @test */
    public function deleting_news_flushes_news_cache()
    {
        // Arrange
        $news = factory(News::class)->create();
        TaggedCache::news()->remember('cache', function () {
            return $this->faker->words(3, true);
        });
        TaggedCache::aNews($news)->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $news->delete();

        // Assert
        $this->assertNull(TaggedCache::news()->getCache()->get('cache'));
        $this->assertNull(TaggedCache::aNews($news->slug)->getCache()->get('cache'));
    }
}
