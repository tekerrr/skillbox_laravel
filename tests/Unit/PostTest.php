<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function method_active_returns_only_published_posts()
    {
        // Arrange
        $publishedPostNumber = 2;
        factory(Post::class, $publishedPostNumber)->create(['is_active' => true]);
        factory(Post::class)->create(['is_active' => false]);

        // Act
        $posts = Post::active();

        // Assert
        $this->assertEquals($posts->count(), $publishedPostNumber);
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
        ]);

        // Act
        $tags = $post->tags;

        // Assert
        $this->assertEquals('AAA', $tags->first()->name);
    }

    /** @test */
    public function an_active_post_is_defined_as_active()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => true]);

        // Act
        $response = $post->isActive();

        // Assert
        $this->assertTrue($response);
    }

    /** @test */
    public function an_inactive_post_is_not_defined_as_active()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => false]);

        // Act
        $response = $post->isActive();

        // Assert
        $this->assertFalse($response);
    }

    /** @test */
    public function a_post_can_be_activated()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => false]);

        // Act
        $post->activate();

        // Assert
        $this->assertTrue($post->isActive());
    }

    /** @test */
    public function a_post_can_be_deactivated()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => true]);

        // Act
        $post->deactivate();

        // Assert
        $this->assertFalse($post->isActive());
    }
}
