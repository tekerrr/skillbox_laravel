<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_class_is_using_can_be_activated_trait_correctly()
    {
        // Arrange
        $elements = factory(Post::class, 2)->create(['is_active' => false]);

        // Act
        $elements->first()->activate();

        // Assert
        $this->assertTrue($elements->first()->isActive());
        $this->assertFalse($elements->last()->isActive());
    }

    /** @test */
    public function a_post_can_have_tags()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $tags = factory(\App\Tag::class, 2)->create();

        // Act
        $post->tags()->attach($tags);

        // Assert
        $this->assertTrue($post->tags()->where('name', $tags->first()->name)->exists());
        $this->assertTrue($post->tags()->where('name', $tags->last()->name)->exists());
    }

    /** @test */
    public function post_tags_are_selected_in_alphabetical_order()
    {
        // Arrange
        $post = factory(Post::class)->create();
        $post->tags()->saveMany([
            factory(\App\Tag::class)->make(['name' => 'ZZZ']),
            factory(\App\Tag::class)->make(['name' => 'AAA']),
            factory(\App\Tag::class)->make(['name' => 'BBB']),
        ]);

        // Act
        $tags = $post->tags;

        // Assert
        $this->assertEquals('AAA', $tags->first()->name);
    }
}
