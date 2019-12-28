<?php

namespace Tests\Unit\Report;

use App\Service\Report\Report;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function method_save_as_csv_saves_file()
    {
        // Arrange
        $report = app(Report::class);
        $name = 'report.csv';

        // Act
        $report->saveAsCsv($name, []);

        // Assert
        \Storage::disk('reports')->assertExists($name);

        // Clean
        $report->delete($name);
    }

    /** @test */
    public function method_get_all_returns_reports()
    {
        // Arrange
        $report = app(Report::class);
        $report->deleteAll();
        $report->saveAsCsv('report1.csv', []);
        $report->saveAsCsv('report2.csv', []);

        // Act
        $reports = $report->getAll();

        // Assert
        $this->assertEquals(2, count($reports));

        // Clean
        $report->deleteAll();
    }

    /** @test */
    public function method_get_full_path_returns_correct_path()
    {
        // Arrange
        $report = app(Report::class);
        $name = 'report.csv';
        $report->saveAsCsv($name, []);

        // Act
        $fullPath = $report->getFullPath($name);

        // Assert
        $this->assertEquals(\Storage::disk('reports')->path($name) , $fullPath);

        // Clean
        $report->delete($name);
    }

    /** @test */
    public function method_download_with_existed_file_returns_streamed_response()
    {
        // Arrange
        $report = app(Report::class);
        $name = 'report.csv';
        $report->saveAsCsv($name, []);

        // Act
        $response = $report->download($name);

        // Assert
        $this->assertEquals('Symfony\Component\HttpFoundation\StreamedResponse', get_class($response));

        // Clean
        $report->delete($name);
    }

    /** @test */
    public function method_download_without_existed_file_returns_null()
    {
       // Act
        $response = app(Report::class)->download('null.csv');

        // Assert
        $this->assertNull($response);
    }

    /** @test */
    public function method_delete_with_string_argument_deletes_file()
    {
        // Arrange
        $report = app(Report::class);
        $name = 'report.csv';
        $report->saveAsCsv($name, []);

        // Act
        $report->delete($name);

        // Assert
        \Storage::disk('reports')->assertMissing($name);
    }

    /** @test */
    public function method_delete_with_array_argument_deletes_files()
    {
        // Arrange
        $report = app(Report::class);
        $firstReport = 'report1.csv';
        $secondReport = 'report2.csv';
        $report->saveAsCsv($firstReport, []);
        $report->saveAsCsv($secondReport, []);

        // Act
        $report->delete([$firstReport, $secondReport]);

        // Assert
        \Storage::disk('reports')->assertMissing($firstReport);
        \Storage::disk('reports')->assertMissing($secondReport);
    }

    /** @test */
    public function method_delete_all_deletes_all_files()
    {
        // Arrange
        $report = app(Report::class);
        $firstReport = 'report1.csv';
        $secondReport = 'report2.csv';
        $report->saveAsCsv($firstReport, []);
        $report->saveAsCsv($secondReport, []);

        // Act
        $report->deleteAll();

        // Assert
        \Storage::disk('reports')->assertMissing($firstReport);
        \Storage::disk('reports')->assertMissing($secondReport);
    }
}
