<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TotalReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $items;
    protected $email;

    public function __construct(array $items, string $email)
    {
        $this->items = $items;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $report = new \App\Service\TotalReport($this->items);
        $report->generate();

        \Mail::to($this->email)->send(new \App\Mail\Reports\Total($report->getReport(), $report->saveAsCsv()));
    }
}
