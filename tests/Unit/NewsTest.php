<?php

namespace Tests\Unit;

use App\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_class_is_using_can_be_activated_trait_correctly()
    {
        // Arrange
        $elements = factory(News::class, 2)->create(['is_active' => false]);

        // Act
        $elements->first()->activate();

        // Assert
        $this->assertTrue($elements->first()->isActive());
        $this->assertFalse($elements->last()->isActive());
    }

    /** @test */
    public function a_news_can_have_tags()
    {
        // Arrange
        $news = factory(News::class)->create();
        $tags = factory(\App\Tag::class, 2)->create();

        // Act
        $news->tags()->attach($tags);

        // Assert
        $this->assertTrue($news->tags()->where('name', $tags->first()->name)->exists());
        $this->assertTrue($news->tags()->where('name', $tags->last()->name)->exists());
    }

    /** @test */
    public function news_tags_are_selected_in_alphabetical_order()
    {
        // Arrange
        $news = factory(News::class)->create();
        $news->tags()->saveMany([
            factory(\App\Tag::class)->make(['name' => 'ZZZ']),
            factory(\App\Tag::class)->make(['name' => 'AAA']),
            factory(\App\Tag::class)->make(['name' => 'BBB']),
        ]);

        // Act
        $tags = $news->tags;

        // Assert
        $this->assertEquals('AAA', $tags->first()->name);
    }
}
