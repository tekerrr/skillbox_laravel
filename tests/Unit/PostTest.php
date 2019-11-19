<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testSelectedOnlyPublishedPosts()
    {
        $publishedPostNumber = 2;
        factory(Post::class, $publishedPostNumber)->create(['is_active' => true]);
        factory(Post::class)->create(['is_active' => false]);

        $posts = Post::active();

        $this->assertEquals($posts->count(), $publishedPostNumber);
    }

    public function testAPostCanHasTags()
    {
        $post = factory(Post::class)->create();
        $tag = factory(\App\Tag::class)->create();

        $post->tags()->attach($tag);

        $this->assertEquals($tag->name, $post->tags->first()->name);
    }

    public function testActivePostCanBeDefinedAsActive()
    {
        $post = factory(Post::class)->create(['is_active' => true]);

        $this->assertTrue($post->isActive());
    }

    public function testInactivePostCannotBeDefinedAsActive()
    {
        $post = factory(Post::class)->create(['is_active' => false]);

        $this->assertFalse($post->isActive());
    }
}
