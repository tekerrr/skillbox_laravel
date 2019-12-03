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
        $attributes = [
            'body' => $this->faker->sentence,
            'commentable_type' => Post::class,
            'commentable_id' => $post->id,
        ];
        $this->actingAsUser();

        // Act
        $this->post('/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function a_user_can_add_a_comment_to_his_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['owner_id' => $this->actingAsUser()]);
        $attributes = [
            'body' => $this->faker->sentence,
            'commentable_type' => Post::class,
            'commentable_id' => $post->id,
        ];

        // Act
        $this->post('/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function an_admin_can_add_a_comment_to_the_post()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $attributes = [
            'body' => $this->faker->sentence,
            'commentable_type' => Post::class,
            'commentable_id' => $post->id,
        ];
        $this->actingAsAdmin();

        // Act
        $this->post('/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function a_user_can_add_a_comment_to_the_news()
    {
        // Arrange
        $news = factory(News::class)->create();
        $attributes = [
            'body' => $this->faker->sentence,
            'commentable_type' => News::class,
            'commentable_id' => $news->id,
        ];
        $this->actingAsUser();

        // Act
        $this->post('/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function an_admin_can_add_a_comment_to_the_news()
    {
        // Arrange
        $news = factory(News::class)->create();
        $attributes = [
            'body' => $this->faker->sentence,
            'commentable_type' => News::class,
            'commentable_id' => $news->id,
        ];
        $this->actingAsAdmin();

        // Act
        $this->post('/comments', $attributes);

        // Assert
        $this->assertDatabaseHas((new \App\Comment())->getTable(), $attributes);
    }

    /** @test */
    public function a_guest_cannot_add_a_comment()
    {
        // Act
        $response = $this->post('/comments', []);

        // Assert
        $response->assertRedirect('/login');
    }
}
