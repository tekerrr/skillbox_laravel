<?php

namespace Tests\Unit;

use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_tag_can_have_posts()
    {
        // Arrange
        $tag = factory(Tag::class)->create();
        $posts = factory(\App\Post::class, 2)->create();

        // Act
        $tag->posts()->attach($posts);

        // Assert
        $this->assertEquals($posts->first()->title, $tag->posts->first()->title);
        $this->assertEquals($posts->last()->title, $tag->posts->last()->title);
    }

    /** @test */
    public function method_tagsCloud_returns_tags()
    {
        // Arrange
        $tagsNumber = 2;
        factory(Tag::class, $tagsNumber)->create()->each(function (Tag $tag) {
            $tag->posts()->attach(factory(\App\Post::class)->create());
        });

        // Act
        $tagsCloud = Tag::tagsCloud();

        // Assert
        $this->assertEquals($tagsCloud->count(), $tagsNumber);
    }

    /** @test */
    public function method_tags_cloud_returns_only_tags_attached_to_posts()
    {
        // Arrange
        $tagsNumber = 2;
        $tags = factory(Tag::class, $tagsNumber)->create();
        $post = factory(\App\Post::class)->create();
        $tags->first()->posts()->attach($post);

        // Act
        $tagsCloud = Tag::tagsCloud();

        // Assert
        $this->assertEquals($tagsCloud->count(), 1);
    }
}
