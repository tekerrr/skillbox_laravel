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
    protected $user;

    public function __construct(array $items, \App\User $user)
    {
        $this->items = $items;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $report = new \App\Service\Report\TotalReport($this->items);
        $report->generate();

        $mail = new \App\Mail\Reports\Total($report->getReport(), $report->saveAsCsv());
        \Mail::to($this->user->email)->send($mail);

        broadcast(new \App\Events\CreatedTotalReport($report->getReport(), $this->user->id));
    }
}
