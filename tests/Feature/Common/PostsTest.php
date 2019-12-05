<?php

namespace Tests\Feature\Common;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class PostsTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function anyone_can_view_the_post_list_page()
    {
        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertViewIs('posts.index');
        $response->assertSeeText('Публикации');
    }

    /** @test */
    public function anyone_can_view_tags_on_the_post_list_page()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $tags = factory(\App\Tag::class, 2)->create();
        $post->tags()->attach($tags);

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText($tags->first()->name);
        $response->assertSeeText($tags->last()->name);
    }

    /** @test */
    public function anyone_can_view_the_post_page()
    {
        // Arrange
        $post = factory(Post::class)->create();

        // Act
        $response = $this->get('/posts/' . $post->slug);

        // Assert
        $response->assertViewIs('posts.show');
        $response->assertSeeText($post->body);
    }

    /** @test */
    public function anyone_can_view_a_post_history_on_the_post_page()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $history = factory(\App\PostHistory::class)->create(['post_id' => $post]);

        // Act
        $response = $this->get('/posts/' . $post->slug);

        // Assert
        $response->assertSeeText(htmlentities($history->before));
        $response->assertSeeText(htmlentities($history->after));
    }

    /** @test */
    public function anyone_can_view_tags_on_the_post_page()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $tags = factory(\App\Tag::class, 2)->create();
        $post->tags()->attach($tags);

        // Act
        $response = $this->get('/posts/' . $post->slug);

        // Assert
        $response->assertSeeText($tags->first()->name);
        $response->assertSeeText($tags->last()->name);
    }

    /** @test */
    public function a_user_can_view_the_post_creation_page()
    {
        // Arrange
        $this->actingAsUser();

        // Act
        $response = $this->get('/posts/create');

        // Assert
        $response->assertViewIs('posts.create');
        $response->assertSeeText('Создание статьи');
    }

    /** @test */
    public function an_admin_can_view_the_post_creation_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/posts/create');

        // Assert
        $response->assertViewIs('posts.create');
        $response->assertSeeText('Создание статьи');
    }

    /** @test */
    public function a_guest_cannot_view_the_post_creation_page()
    {
        // Act
        $response = $this->get('/posts/create');

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_a_post()
    {
        // Arrange
        $attributes = factory(Post::class)->raw(['owner_id' => $this->actingAsUser()]);

        // Act
        $this->post('posts', $attributes);

        // Assert
        $this->assertDatabaseHas((new Post)->getTable(), $attributes);
    }

    /** @test */
    public function a_user_can_create_a_post_with_tags()
    {
        // Arrange
        $attributes = factory(Post::class)->raw([
            'owner_id' => $this->actingAsUser(),
            'tags'     => $tagName = $this->faker->word,
        ]);

        // Act
        $this->post('posts', $attributes);

        // Assert
        $this->assertEquals(Post::first()->tags->first()->name, $tagName);
    }

    /** @test */
    public function an_admin_can_create_a_post()
    {
        // Arrange
        $attributes = factory(Post::class)->raw(['owner_id' => $this->actingAsAdmin()]);

        // Act
        $this->post('posts', $attributes);

        // Assert
        $this->assertDatabaseHas((new Post)->getTable(), $attributes);
    }

    /** @test */
    public function a_guest_cannot_create_a_post()
    {
        // Act
        $response = $this->post('posts', []);

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_view_the_his_post_editing_page()
    {
        // Arrange
        $post = factory(Post::class)->create(['owner_id' => $this->actingAsUser()]);

        // Act
        $response = $this->get('/posts/' . $post->slug . '/edit');

        // Assert
        $response->assertViewIs('posts.edit');
        $response->assertSeeText('Редактирование статьи');
    }

    /** @test */
    public function a_user_cannot_view_the_another_users_post_editing_page()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $this->actingAsUser();

        // Act
        $response = $this->get('/posts/' . $post->slug . '/edit');

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_view_the_post_editing_page()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/posts/' . $post->slug . '/edit');

        // Assert
        $response->assertViewIs('posts.edit');
        $response->assertSeeText('Редактирование статьи');
    }

    /** @test */
    public function a_guest_cannot_view_the_post_editing_page()
    {
        // Arrange
        $post = factory(Post::class)->create();

        // Act
        $response = $this->get('/posts/' . $post->slug . '/edit');

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_update_his_post()
    {
        // Arrange
        $attributes = factory(Post::class)->raw(['owner_id' => $this->actingAsUser()]);
        Post::create($attributes);

        // Act
        $attributes['title'] = $this->faker->words(3, true);
        $this->patch('/posts/' . $attributes['slug'], $attributes);

        // Assert
        $this->assertDatabaseHas((new Post())->getTable(), $attributes);
    }

    /** @test */
    public function a_user_can_update_tags_in_his_post()
    {
        // Arrange
        $attributes = factory(Post::class)->raw([
            'owner_id' => $this->actingAsUser(),
            'tags' => $oldTagName = $this->faker->unique()->word,
        ]);
        Post::create($attributes);

        // Act
        $attributes['tags'] = $newTagName = $this->faker->unique()->word;
        $this->patch('/posts/' . $attributes['slug'], $attributes);

        // Assert
        $this->assertEquals(Post::first()->tags()->first()->name, $newTagName);
        $this->assertNull(Post::first()->tags()->where('name', $oldTagName)->first());
    }

    /** @test */
    public function a_user_cannot_update_another_users_post()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $this->actingAsUser();

        // Act
        $response = $this->patch('/posts/' . $post->slug, []);

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_update_a_post()
    {
        // Arrange
        Post::create($attributes = factory(Post::class)->raw());
        $this->actingAsAdmin();

        // Act
        $attributes['title'] = $this->faker->words(3, true);
        $this->patch('/posts/' . $attributes['slug'], $attributes);

        // Assert
        $this->assertDatabaseHas((new Post())->getTable(), $attributes);
    }

    /** @test */
    public function a_guest_cannot_update_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create();

        // Act
        $response = $this->patch('/posts/' . $post->slug, []);

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_delete_his_post()
    {
        // Arrange
        $user = $this->actingAsUser();
        Post::create($attributes = factory(Post::class)->raw(['owner_id' => $user]));

        // Act
        $this->delete('/posts/' . $attributes['slug']);

        // Assert
        $this->assertDatabaseMissing((new Post())->getTable(), $attributes);
    }

    /** @test */
    public function a_user_cannot_delete_other_users_post()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $this->actingAsUser();

        // Act
        $response = $this->delete('/posts/' . $post->slug);

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_delete_a_post()
    {
        // Arrange
        Post::create($attributes = factory(Post::class)->raw());
        $this->actingAsAdmin();

        // Act
        $this->delete('/posts/' . $attributes['slug']);

        // Assert
        $this->assertDatabaseMissing((new Post())->getTable(), $attributes);
    }

    /** @test */
    public function a_guest_cannot_delete_a_post()
    {
        // Arrange
        $post = factory(Post::class)->create();

        // Act
        $response = $this->delete('/posts/' . $post->slug);

        // Assert
        $response->assertRedirect('/login');
    }
}
