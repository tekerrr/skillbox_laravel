<?php

namespace Tests\Unit;

use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function testATagHasPosts()
    {
        $tag = factory(Tag::class)->create();
        $post = factory(\App\Post::class)->create();

        $tag->posts()->attach($post);

        $this->assertEquals($post->title, $tag->posts->first()->title);
    }

    public function testCanTakeTagsCloud()
    {
        $tagsNumber = 2;
        factory(Tag::class, $tagsNumber)->create()->each(function (Tag $tag) {
            $tag->posts()->attach(factory(\App\Post::class)->create());
        });

        $tagsCloud = Tag::tagsCloud();

        $this->assertEquals($tagsCloud->count(), $tagsNumber);
    }

    public function testTagsCloudHasOnlyTagsWithPost()
    {
        $tagsNumber = 2;
        $tags = factory(Tag::class, $tagsNumber)->create();
        $post = factory(\App\Post::class)->create();
        $tags->first()->posts()->attach($post);

        $tagsCloud = Tag::tagsCloud();

        $this->assertEquals($tagsCloud->count(), $tagsNumber - 1);
    }
}
