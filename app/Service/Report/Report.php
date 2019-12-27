<?php


namespace App\Service\Report;


use Illuminate\Support\Arr;

class Report
{
    private $disk;

    public function __construct()
    {
        $this->disk = \Storage::disk('reports');
    }

    public function getAll(): array
    {
        return Arr::where($this->disk->files(), function ($name) {
            return $name != '.gitkeep';
        });
    }

    public function getFullPath(string $report) : string
    {
        return $this->disk->path($report);
    }

    public function download(string $report) : ?\Symfony\Component\HttpFoundation\StreamedResponse
    {
        return $this->disk->exists($report) ? $this->disk->download($report) : null;
    }

    public function saveAsCsv(string $name, array $data)
    {
        \League\Csv\Writer::createFromPath($this->getFullPath($name), 'w+')->insertAll($data);
    }

    public function deleteAll()
    {
        $this->delete($this->getAll());
    }

    private function delete($reports)
    {
        $this->disk->delete($reports);
    }
}
