<?php

namespace Tests\Unit;

use App\Post;
use App\Service\TaggedCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function the_class_is_using_can_be_activated_trait_correctly()
    {
        // Arrange
        $this->actingAsUser();
        $elements = factory(Post::class, 2)->create(['is_active' => false]);

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
        $post = factory(Post::class)->create();

        // Act
        $response = Post::getBindingModel($post->slug);

        // Assert
        $this->assertEquals($post->title, $response->title);
    }

    /** @test */
    public function a_post_has_a_user()
    {
        // Arrange
        $post = factory(Post::class)->create(['owner_id' => $user = $this->createUser()]);

        // Act
        $owner = $post->user;

        // Assert
        $this->assertEquals($owner->name, $user->name);
    }

    /** @test */
    public function a_post_can_have_tags()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $tags = factory(\App\Tag::class, 2)->create();

        // Act
        $post->tags()->attach($tags);

        // Assert
        $this->assertTrue($post->tags()->where('name', $tags->first()->name)->exists());
        $this->assertTrue($post->tags()->where('name', $tags->last()->name)->exists());
    }

    /** @test */
    public function post_tags_are_selected_in_alphabetical_order()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $post->tags()->saveMany([
            factory(\App\Tag::class)->make(['name' => 'ZZZ']),
            factory(\App\Tag::class)->make(['name' => 'AAA']),
            factory(\App\Tag::class)->make(['name' => 'BBB']),
        ]);

        // Act
        $tags = $post->tags;

        // Assert
        $this->assertEquals('AAA', $tags->first()->name);
    }

    /** @test */
    public function a_post_can_have_comments()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $comments = factory(\App\Comment::class, 2)->state('withoutCommentable')->make();

        // Act
        $post->comments()->saveMany($comments);

        // Assert
        $this->assertEquals($post->comments->first()->body, $comments->first()->body);
        $this->assertEquals($post->comments->last()->body, $comments->last()->body);
    }

    /** @test */
    public function a_post_can_have_a_history()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $history = factory(\App\PostHistory::class)->create(['post_id' => $post]);

        // Act
        $postHistory = $post->history->first();

        // Assert
        $this->assertEquals($postHistory->name, \App\User::find($history->user_id)->name);
        $this->assertEquals($postHistory->pivot->before, $history->before);
    }

    /** @test */
    public function a_post_history_stores_changes()
    {
        // Arrange
        $post = factory(Post::class)->create(['owner_id' => $this->actingAsUser()]);
        $oldTitle = $post->title;
        $newTitle = $this->faker->words(3, true);

        // Act
        $post->update(['title' => $newTitle]);

        // Assert
        $this->assertDatabaseHas((new \App\PostHistory())->getTable(), ['before' => json_encode(['title' => $oldTitle])]);
        $this->assertDatabaseHas((new \App\PostHistory())->getTable(), ['after' => json_encode(['title' => $newTitle])]);
    }

    /** @test */
    public function comments_are_deleted_when_the_post_is_deleted()
    {
        // Arrange
        factory(\App\Comment::class, 2)->create();
        $post = factory(Post::class)->create();
        $comment = factory(\App\Comment::class)->state('withoutCommentable')->make();
        $post->comments()->save($comment);

        // Act
        $post->delete();

        // Assert
        $this->assertEquals(2, \App\Comment::count());
    }

    /** @test */
    public function creating_post_flushes_posts_cache()
    {
        // Arrange
        TaggedCache::posts()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        factory(Post::class)->create();

        // Assert
        $this->assertNull(TaggedCache::posts()->getCache()->get('cache'));
    }

    /** @test */
    public function updating_post_flushes_posts_cache()
    {
        // Arrange
        $this->actingAsUser();
        $post = factory(Post::class)->create();
        TaggedCache::posts()->remember('cache', function () {
            return $this->faker->words(3, true);
        });
        TaggedCache::post($post)->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $post->update(['title' => $this->faker->words(3, true)]);

        // Assert
        $this->assertNull(TaggedCache::posts()->getCache()->get('cache'));
        $this->assertNull(TaggedCache::post($post->slug)->getCache()->get('cache'));
    }

    /** @test */
    public function deleting_post_flushes_posts_cache()
    {
        // Arrange
        $post = factory(Post::class)->create();
        TaggedCache::posts()->remember('cache', function () {
            return $this->faker->words(3, true);
        });
        TaggedCache::post($post)->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $post->delete();

        // Assert
        $this->assertNull(TaggedCache::posts()->getCache()->get('cache'));
        $this->assertNull(TaggedCache::post($post->slug)->getCache()->get('cache'));
    }
}
