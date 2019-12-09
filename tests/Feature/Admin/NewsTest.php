<?php

namespace Tests\Feature\Admin;

use App\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class NewsTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function an_admin_can_view_the_news_list_admin_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/news');

        // Assert
        $response->assertViewIs('admin.news.index');
        $response->assertSeeText('Список новостей');
    }

    /** @test */
    public function an_admin_can_view_the_news_creation_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/news/create');

        // Assert
        $response->assertViewIs('admin.news.create');
        $response->assertSeeText('Создание новости');
    }

    /** @test */
    public function an_admin_can_create_a_news()
    {
        // Arrange
        $this->actingAsAdmin();
        $attributes = factory(News::class)->raw();

        // Act
        $this->post('/admin/news', $attributes);

        // Assert
        $this->assertDatabaseHas((new News)->getTable(), $attributes);
    }

    /** @test */
    public function an_admin_can_create_a_news_with_tags()
    {
        // Arrange
        $this->actingAsAdmin();
        $attributes = factory(News::class)->raw([
            'tags' => $tagName = $this->faker->word,
        ]);

        // Act
        $this->post('/admin/news', $attributes);

        // Assert
        $this->assertEquals(News::first()->tags->first()->name, $tagName);
    }

    /** @test */
    public function a_user_cannot_create_a_news()
    {
        // Arrange
        $this->actingAsUser();

        // Act
        $response = $this->post('/admin/news', []);

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_create_a_news()
    {
        // Act
        $response = $this->post('/admin/news', []);

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function the_non_unique_slug_fails_the_news_creation_validation_rules()
    {
        // Arrange
        $this->actingAsAdmin();
        $slug = $this->faker->word;
        factory(News::class)->create(['slug' => $slug]);
        $attributes = factory(News::class)->raw(['slug' => $slug]);

        // Act
        $response = $this->post('/admin/news', $attributes);

        // Assert
        $response->assertSessionHasErrors(['slug']);
    }

    /** @test */
    public function an_admin_can_view_the_news_editing_page()
    {
        // Arrange
        $news = factory(News::class)->create();
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/news/' . $news->slug . '/edit');

        // Assert
        $response->assertViewIs('admin.news.edit');
        $response->assertSeeText('Редактирование новости');
    }

    /** @test */
    public function an_admin_can_update_a_news()
    {
        // Arrange
        News::create($attributes = factory(News::class)->raw());
        $this->actingAsAdmin();

        // Act
        $attributes['title'] = $this->faker->words(3, true);
        $this->patch('/admin/news/' . $attributes['slug'], $attributes);

        // Assert
        $this->assertDatabaseHas((new News())->getTable(), $attributes);
    }

    /** @test */
    public function an_admin_can_update_tags_in_a_news()
    {
        // Arrange
        $this->actingAsAdmin();
        $attributes = factory(News::class)->raw([
            'tags' => $oldTagName = $this->faker->unique()->word,
        ]);
        News::create($attributes);

        // Act
        $attributes['tags'] = $newTagName = $this->faker->unique()->word;
        $this->patch('/admin/news/' . $attributes['slug'], $attributes);

        // Assert
        $this->assertEquals(News::first()->tags()->first()->name, $newTagName);
        $this->assertNull(News::first()->tags()->where('name', $oldTagName)->first());
    }

    /** @test */
    public function a_user_cannot_update_a_news()
    {
        // Arrange
        $news = factory(News::class)->create();
        $this->actingAsUser();

        // Act
        $response = $this->patch('/admin/news/' . $news->slug, []);

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_update_a_news()
    {
        // Arrange
        $news = factory(News::class)->create();

        // Act
        $response = $this->patch('/admin/news/' . $news->slug, []);

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function the_non_unique_slug_fails_the_news_updating_validation_rules()
    {
        // Arrange
        $this->actingAsAdmin();
        $slug = $this->faker->word;
        factory(News::class)->create(['slug' => $slug]);
        $attributes = factory(News::class)->raw();
        $news = News::create($attributes);

        // Act
        $attributes['slug'] = $slug;
        $response = $this->patch('/admin/news/' . $news->slug, $attributes);

        // Assert
        $response->assertSessionHasErrors(['slug']);
    }

    /** @test */
    public function an_admin_can_delete_a_news()
    {
        // Arrange
        News::create($attributes = factory(News::class)->raw());
        $this->actingAsAdmin();

        // Act
        $this->delete('/admin/news/' . $attributes['slug']);

        // Assert
        $this->assertDatabaseMissing((new News())->getTable(), $attributes);
    }

    /** @test */
    public function a_user_cannot_delete_a_news()
    {
        // Arrange
        $news = factory(News::class)->create();
        $this->actingAsUser();

        // Act
        $response = $this->delete('/admin/news/' . $news->slug);

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_delete_a_news()
    {
        // Arrange
        $news = factory(News::class)->create();

        // Act
        $response = $this->delete('/admin/news/' . $news->slug);

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function an_admin_can_activate_a_news()
    {
        // Arrange
        $news = factory(News::class)->create(['is_active' => false]);
        $this->actingAsAdmin();

        // Act
        $this->patch('/admin/news/' . $news->slug . '/activate');

        // Assert
        $this->assertTrue(News::first()->isActive());
    }

    /** @test */
    public function a_user_cannot_activate_a_news()
    {
        // Arrange
        $news = factory(News::class)->create(['is_active' => false]);
        $this->actingAsUser();

        // Act
        $this->patch('/admin/news/' . $news->slug . '/activate');

        // Assert
        $this->assertFalse(News::first()->isActive());
    }

    /** @test */
    public function a_guest_cannot_activate_a_news()
    {
        // Arrange
        $news = factory(News::class)->create(['is_active' => false]);

        // Act
        $this->patch('/admin/news/' . $news->slug . '/activate');

        // Assert
        $this->assertFalse(News::first()->isActive());
    }

    /** @test */
    public function an_admin_can_deactivate_a_news()
    {
        // Arrange
        $news = factory(News::class)->create(['is_active' => true]);
        $this->actingAsAdmin();

        // Act
        $this->patch('/admin/news/' . $news->slug . '/deactivate');

        // Assert
        $this->assertFalse(News::first()->isActive());
    }

    /** @test */
    public function a_user_cannot_deactivate_a_news()
    {
        // Arrange
        $news = factory(News::class)->create(['is_active' => true]);
        $this->actingAsUser();

        // Act
        $this->patch('/admin/news/' . $news->slug . '/deactivate');

        // Assert
        $this->assertTrue(News::first()->isActive());
    }

    /** @test */
    public function a_guest_cannot_deactivate_a_news()
    {
        // Arrange
        $news = factory(News::class)->create(['is_active' => true]);

        // Act
        $this->patch('/admin/news/' . $news->slug . '/deactivate');

        // Assert
        $this->assertTrue(News::first()->isActive());
    }
}
