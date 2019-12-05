<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\WithRoles;

class BasicRoutesTest extends TestCase
{
    use RefreshDatabase, WithRoles;

    /** @test */
    public function an_admin_can_view_the_admin_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin');

        // Assert
        $response->assertViewIs('admin.index');
        $response->assertSeeText('Административный раздел');
    }

    /** @test */
    public function a_user_cannot_view_the_admin_page()
    {
        // Arrange
        $this->actingAsUser();

        // Act
        $response = $this->get('/admin');

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_view_the_admin_page()
    {
        // Act
        $response = $this->get('/admin');

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function an_admin_can_view_the_admin_statistics_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/statistics');

        // Assert
        $response->assertSeeText('Статистика портала');
        $response->assertViewIs('admin.statistics');
    }

    /** @test */
    public function a_user_cannot_view_the_admin_statistics_page()
    {
        // Arrange
        $this->actingAsUser();

        // Act
        $response = $this->get('/admin/statistics');

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_view_the_admin_statistics_page()
    {
        // Act
        $response = $this->get('/admin/statistics');

        // Assert
        $response->assertRedirect('/login');
    }
}
