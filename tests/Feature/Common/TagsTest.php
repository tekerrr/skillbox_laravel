<?php

namespace Tests\Feature\Common;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_view_the_news_and_post_list_attached_to_tag_page()
    {
        // Arrange
        $tag = factory(\App\Tag::class)->create();
        $attachedNews = factory(\App\News::class)->create();
        $detachedNews = factory(\App\News::class)->create();
        $attachedPost = factory(\App\Post::class)->create();
        $detachedPost = factory(\App\Post::class)->create();
        $tag->news()->attach($attachedNews);
        $tag->posts()->attach($attachedPost);

        // Act
        $response = $this->get('/tags/' . $tag->id);

        // Assert
        $response->assertViewIs('tags.show');
        $response->assertSeeText($attachedNews->title);
        $response->assertDontSeeText($detachedNews->title);
        $response->assertSeeText($attachedPost->title);
        $response->assertDontSeeText($detachedPost->title);
    }
}
