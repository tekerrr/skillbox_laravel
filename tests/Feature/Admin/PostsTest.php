<?php

namespace Tests\Feature\Admin;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class PostsTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function an_admin_can_view_the_post_list_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/posts');

        // Assert
        $response->assertViewIs('admin.posts');
        $response->assertSeeText('Список статей');
    }

    /** @test */
    public function a_user_cannot_view_the_post_list_admin_page()
    {
        // Arrange
        $this->actingAsUser();

        // Act
        $response = $this->get('/admin/posts');

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_view_the_post_list_admin_page()
    {
        // Act
        $response = $this->get('/admin/posts');

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function an_admin_can_activate_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => false]);
        $this->actingAsAdmin();

        // Act
        $this->patch('/admin/posts/' . $post->slug . '/activate');

        // Assert
        $this->assertTrue(Post::first()->isActive());
    }

    /** @test */
    public function a_user_cannot_activate_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => false]);
        $this->actingAsUser();

        // Act
        $this->patch('/admin/posts/' . $post->slug . '/activate');

        // Assert
        $this->assertFalse(Post::first()->isActive());
    }

    /** @test */
    public function a_guest_cannot_activate_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => false]);

        // Act
        $this->patch('/admin/posts/' . $post->slug . '/activate');

        // Assert
        $this->assertFalse(Post::first()->isActive());
    }

    /** @test */
    public function an_admin_can_deactivate_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => true]);
        $this->actingAsAdmin();

        // Act
        $this->patch('/admin/posts/' . $post->slug . '/deactivate');

        // Assert
        $this->assertFalse(Post::first()->isActive());
    }

    /** @test */
    public function a_user_cannot_deactivate_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => true]);
        $this->actingAsUser();

        // Act
        $this->patch('/admin/posts/' . $post->slug . '/deactivate');

        // Assert
        $this->assertTrue(Post::first()->isActive());
    }

    /** @test */
    public function a_guest_cannot_deactivate_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create(['is_active' => true]);

        // Act
        $this->patch('/admin/posts/' . $post->slug . '/deactivate');

        // Assert
        $this->assertTrue(Post::first()->isActive());
    }
}
