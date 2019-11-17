<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use RefreshDatabase;

    public function testAnyoneCanViewIndexPage()
    {
        $tag = factory(\App\Tag::class)->create();
        $attachedPost = factory(\App\Post::class)->create();
        $detachedPost = factory(\App\Post::class)->create();
        $tag->posts()->attach($attachedPost);

        $response = $this->get('/posts/tags/' . $tag->id);

        $response->assertViewIs('posts.index');
        $response->assertSeeText($attachedPost->title);
        $response->assertDontSeeText($detachedPost->title);
    }
}
