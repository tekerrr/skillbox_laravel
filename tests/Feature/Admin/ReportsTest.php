<?php

namespace Tests\Feature\Admin;

use App\Service\Report\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class ReportsTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;



    /** @test */
    public function an_admin_can_view_empty_list_on_the_admin_saved_report_list_page()
    {
        // Arrange
        $this->actingAsAdmin();
        app(Report::class)->deleteAll();

        // Act
        $response = $this->get('/admin/reports/files');

        // Assert
        $response->assertSeeText('Отчёты отсутствуют');
        $response->assertDontSeeText('.gitkeep');
    }

    /** @test */
    public function an_admin_can_view_saved_reports_on_the_admin_saved_report_list_page()
    {
        // Arrange
        $this->actingAsAdmin();
        $report = 'report.csv';
        app(Report::class)->saveAsCsv($report, []);

        // Act
        $response = $this->get('/admin/reports/files');

        // Assert
        $response->assertSeeText($report);
        $response->assertDontSeeText($this->faker->word);

        // Clean
        app(Report::class)->delete($report);
    }

    /** @test */
    public function an_admin_can_download_saved_report()
    {
        // Arrange
        $this->actingAsAdmin();
        $report = 'report.csv';
        app(Report::class)->saveAsCsv($report, []);

        // Act
        $response = $this->get('/admin/reports/files/' . $report);

        // Assert
        $response->assertHeader('Content-Disposition', 'attachment; filename=' . $report);

        // Clean
        app(Report::class)->delete($report);
    }

    /** @test */
    public function an_admin_can_delete_all_saved_reports()
    {
        // Arrange
        $this->actingAsAdmin();
        $report = 'report.csv';
        app(Report::class)->saveAsCsv($report, []);

        // Act
        $this->delete('/admin/reports/files');

        // Assert
        $this->assertEmpty(app(Report::class)->getAll());
    }

    /** @test */
    public function an_admin_can_create_total_report()
    {
        // Arrange
        $this->actingAsAdmin();
        \Queue::fake();

        // Act
        $this->post('/admin/reports/total', ['users' => true]);

        // Assert
        \Queue::assertPushed(\App\Jobs\TotalReport::class);
    }

    /** @test */
    public function an_admin_cannot_create_total_report_without_parameters()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->post('/admin/reports/total', []);

        // Assert
        $response->assertSessionHas('message', 'Не выбрано ни одного параметра.');
    }
}
