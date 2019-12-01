<?php

namespace Tests\Feature\Common;

use App\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function anyone_can_view_the_news_list_page()
    {
        // Act
        $response = $this->get('/news');

        // Assert
        $response->assertViewIs('news.index');
        $response->assertSeeText('Новости');
    }

    /** @test */
    public function anyone_can_view_the_concrete_news_page()
    {
        // Arrange
        $news = factory(News::class)->create();

        // Act
        $response = $this->get('/news/' . $news->slug);

        // Assert
        $response->assertViewIs('news.show');
        $response->assertSeeText($news->body);
    }
}
