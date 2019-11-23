<?php

namespace Tests\Feature\Common;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function default_redirect()
    {
        // Act
        $response = $this->get('/');

        // Assert
        $response->assertRedirect('/posts');
    }

    /** @test */
    public function anyone_can_view_the_about_page()
    {
        // Act
        $response = $this->get('/about');

        // Assert
        $response->assertViewIs('about');
        $response->assertSeeText('О нас');
    }

    /** @test */
    public function anyone_can_view_the_contacts_page()
    {
        // Act
        $response = $this->get('/contacts');

        // Assert
        $response->assertViewIs('contacts');
        $response->assertSeeText('Контакты');
    }
}
