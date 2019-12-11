<?php

namespace Tests\Feature\Common;

use App\News;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class CommentsTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function a_user_can_add_a_comment_to_the_post()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $attributes = ['body' => $this->faker->sentence];
        $this->actingAsUser();

        // Act
        $this->post('/posts/'. $post->slug . '/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function a_user_can_add_a_comment_to_his_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['owner_id' => $this->actingAsUser()]);
        $attributes = ['body' => $this->faker->sentence];

        // Act
        $this->post('/posts/'. $post->slug . '/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function an_admin_can_add_a_comment_to_the_post()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $attributes = ['body' => $this->faker->sentence];
        $this->actingAsAdmin();

        // Act
        $this->post('/posts/'. $post->slug . '/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function a_guest_cannot_add_a_comment_to_the_post()
    {
        // Arrange
        $post = factory(Post::class)->create();

        // Act
        $response = $this->post('/posts/'. $post->slug . '/comments', []);

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_add_a_comment_to_the_news()
    {
        // Arrange
        $news = factory(News::class)->create();
        $attributes = ['body' => $this->faker->sentence];
        $this->actingAsUser();

        // Act
        $this->post('/news/'. $news->slug . '/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function an_admin_can_add_a_comment_to_the_news()
    {
        // Arrange
        $news = factory(News::class)->create();
        $attributes = ['body' => $this->faker->sentence];
        $this->actingAsAdmin();

        // Act
        $this->post('/news/'. $news->slug . '/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function a_guest_cannot_add_a_comment()
    {
        // Arrange
        $news = factory(News::class)->create();

        // Act
        $response = $this->post('/news/'. $news->slug . '/comments', []);

        // Assert
        $response->assertRedirect('/login');
    }
}
