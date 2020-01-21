<?php

namespace Tests\Unit;

use App\Comment;
use App\Service\TaggedCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithRoles;
    use WithFaker;

        /** @test */
    public function a_comment_has_a_user()
    {
        // Arrange
        $comment = factory(Comment::class)->create(['owner_id' => $user = $this->createUser()]);

        // Act
        $owner = $comment->user;

        // Assert
        $this->assertEquals($owner->name, $user->name);
    }

    /** @test */
    public function creating_comment_flushes_comments_cache()
    {
        // Arrange
        TaggedCache::comments()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        factory(Comment::class)->create();

        // Assert
        $this->assertNull(TaggedCache::comments()->getCache()->get('cache'));
    }

    /** @test */
    public function updating_comment_flushes_comments_cache()
    {
        // Arrange
        $comment = factory(Comment::class)->create();
        TaggedCache::comments()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $comment->update(['body' => $this->faker->words(3, true)]);

        // Assert
        $this->assertNull(TaggedCache::comments()->getCache()->get('cache'));
    }

    /** @test */
    public function deleting_comment_flushes_comments_cache()
    {
        // Arrange
        $comment = factory(Comment::class)->create();
        TaggedCache::comments()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $comment->delete();

        // Assert
        $this->assertNull(TaggedCache::news()->getCache()->get('cache'));
    }

    /** @test */
    public function changing_comment_flushes_only_commentable_cache()
    {
        // Arrange
        $post = factory(\App\Post::class)->create();
        $post->comments()->create(factory(Comment::class)->raw());
        TaggedCache::post($post->slug)->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        $news = factory(\App\News::class)->create();
        $newsCache = TaggedCache::aNews($news->slug)->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $post->comments()->first()->update(['body' => $this->faker->words(3, true)]);

        // Assert
        $this->assertNull(TaggedCache::post($post->slug)->getCache()->get('cache'));
        $this->assertEquals($newsCache, TaggedCache::aNews($news->slug)->getCache()->get('cache'));
    }
}
