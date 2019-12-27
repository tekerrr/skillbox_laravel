<?php

namespace Tests\Unit\Report;

use App\Service\Report\Report;
use App\Service\Report\TotalReport;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TotalPostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function class_can_generate_report()
    {
        // Arrange
        $report = new TotalReport(['users']);

        // Act
        $report->generate();

        // Assert
        $this->assertEquals(User::count(), $report->getReport()['Пользователи']);
    }

    /** @test */
    public function method_save_as_csv_saves_file()
    {
        // Arrange
        $report = new TotalReport(['users']);

        // Act
        $name = $report->saveAsCsv();

        // Assert
        \Storage::disk('reports')->assertExists($name);

        // Clean
        app(\App\Service\Report\Report::class)->delete($name);
    }
}
