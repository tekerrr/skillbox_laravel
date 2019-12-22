<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class BasicRoutesTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function an_admin_can_view_the_base_admin_page()
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
    public function a_user_cannot_view_the_base_admin_page()
    {
        // Arrange
        $this->actingAsUser();

        // Act
        $response = $this->get('/admin');

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_user_cannot_view_any_other_admin_page()
    {
        // Arrange
        $routes = [
            '/admin/feedback',
            '/admin/statistics',
            '/admin/posts',
            '/admin/news',
            '/admin/news/create',
        ];
        $this->actingAsUser();

        // Act
        $response = $this->get($this->faker->randomElement($routes));

        // Assert
        $response->assertStatus(403);
    }

    /** @test */
    public function a_guest_cannot_view_the_base_admin_page()
    {
        // Act
        $response = $this->get('/admin');

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_guest_cannot_view_any_other_admin_page()
    {
        // Arrange
        $routes = [
            '/admin/feedback',
            '/admin/statistics',
            '/admin/posts',
            '/admin/news',
            '/admin/news/create',
        ];

        // Act
        $response = $this->get($this->faker->randomElement($routes));

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
    public function an_admin_can_view_the_admin_reports_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/reports');

        // Assert
        $response->assertSeeText('Отчёты');
        $response->assertViewIs('admin.reports.index');
    }

    /** @test */
    public function an_admin_can_view_the_admin_total_report_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/reports/total');

        // Assert
        $response->assertSeeText('Отчёт: Итого');
        $response->assertViewIs('admin.reports.total');
    }
}
