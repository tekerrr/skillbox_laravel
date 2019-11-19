<?php

namespace Tests\Feature;

use App\Post;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testAnyoneCanViewIndexPage()
    {
        $response = $this->get('/posts');

        $response->assertViewIs('posts.index');
    }

    public function testAnyoneCanViewShowPostPage()
    {
        $post = factory(Post::class)->create();

        $response = $this->get('/posts/' . $post->slug);

        $response->assertViewIs('posts.show');
    }

    public function testAUserCanViewCreatePostPage()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->get('/posts/create');

        $response->assertViewIs('posts.create');
    }

    public function testGuestCannotViewCreatePostPage()
    {
        $response = $this->get('/posts/create');

        $response->assertRedirect('/login');
    }

    public function testAUserCanCreateAPost()
    {
        $this->actingAs($user = factory(User::class)->create());
        $attributes = factory(Post::class)->raw(['owner_id' => $user]);

        $this->post('posts', $attributes);

        $this->assertDatabaseHas((new Post)->getTable(), $attributes);
    }

    public function testAUserCanCreateAPostWithTags()
    {
        $this->actingAs($user = factory(User::class)->create());
        $attributes = factory(Post::class)->raw([
            'owner_id' => $user,
            'tags'     => $tagName = $this->faker->word,
        ]);

        $this->post('posts', $attributes);

        $this->assertEquals(Post::first()->tags->first()->name, $tagName);
    }

    public function testGuestCannotCreateAPost()
    {
        $response = $this->post('posts', []);

        $response->assertRedirect('/login');
    }

    public function testAUserCanViewEditHisPostPage()
    {
        $this->actingAs($user = factory(User::class)->create());
        $post = factory(Post::class)->create(['owner_id' => $user]);

        $response = $this->get('/posts/' . $post->slug . '/edit');

        $response->assertViewIs('posts.edit');
    }

    public function testAUserCanViewEditOtherUsersPostPage()
    {
        $this->actingAs($owner = factory(User::class)->create());
        $post = factory(Post::class)->create(['owner_id' => $owner]);

        $this->actingAs(factory(User::class)->create());
        $response = $this->get('/posts/' . $post->slug . '/edit');

        $response->assertStatus(403);
    }

    public function testGuestCannotViewEditPostPage()
    {
        $post = factory(Post::class)->create();
        $response = $this->get('/posts/' . $post->slug . '/edit');

        $response->assertStatus(403);
    }

    public function testAUserCanUpdateHisPost()
    {
        $this->actingAs($user = factory(User::class)->create());
        $attributes = factory(Post::class)->raw(['owner_id' => $user]);
        Post::create($attributes);

        $attributes['title'] = $this->faker->words(3, true);
        $this->patch('/posts/' . $attributes['slug'], $attributes);

        $this->assertDatabaseHas((new Post())->getTable(), $attributes);
    }

    public function testAUserCannotUpdateOtherUsersPost()
    {
        $this->actingAs($owner = factory(User::class)->create());
        $post = factory(Post::class)->create(['owner_id' => $owner]);

        $this->actingAs(factory(User::class)->create());
        $response = $this->patch('/posts/' . $post->slug, []);

        $response->assertStatus(403);
    }

    public function testGuestCannotUpdatePost()
    {
        $post = factory(Post::class)->create();

        $response = $this->patch('/posts/' . $post->slug, []);

        $response->assertStatus(403);
    }

    public function testAUserCanDeleteHisPost()
    {
        $this->actingAs($user = factory(User::class)->create());
        $attributes = factory(Post::class)->raw(['owner_id' => $user]);
        Post::create($attributes);

        $this->delete('/posts/' . $attributes['slug']);

        $this->assertDatabaseMissing((new Post())->getTable(), $attributes);
    }

    public function testAUserCannotDeleteOtherUsersPost()
    {
        $this->actingAs($owner = factory(User::class)->create());
        $post = factory(Post::class)->create(['owner_id' => $owner]);

        $this->actingAs(factory(User::class)->create());
        $response = $this->delete('/posts/' . $post->slug);

        $response->assertStatus(403);
    }

    public function testGuestCannotDeletePost()
    {
        $post = factory(Post::class)->create();

        $response = $this->delete('/posts/' . $post->slug);

        $response->assertStatus(403);
    }
}
