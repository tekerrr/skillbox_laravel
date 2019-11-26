<?php

namespace Tests\Feature\Common;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_view_the_post_list_attached_to_tag_page()
    {
        // Arrange
        $tag = factory(\App\Tag::class)->create();
        $attachedPost = factory(\App\Post::class)->create();
        $detachedPost = factory(\App\Post::class)->create();
        $tag->posts()->attach($attachedPost);

        // Act
        $response = $this->get('/posts/tags/' . $tag->id);

        // Assert
        $response->assertViewIs('posts.index');
        $response->assertSeeText($attachedPost->title);
        $response->assertDontSeeText($detachedPost->title);
    }
}
