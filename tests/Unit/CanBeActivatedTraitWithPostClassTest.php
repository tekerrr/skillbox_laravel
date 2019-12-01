<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanBeActivatedTraitWithPostClassTest extends TestCase
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
