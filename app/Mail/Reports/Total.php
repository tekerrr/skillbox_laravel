<?php

namespace App\Mail\Reports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Total extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $csv;
    public $csvName;

    public function __construct($report, $csv)
    {
        $this->report = $report;
        $this->csv = $csv;
        $this->csvName = collect(explode('/', $csv))->last();
    }

    public function build()
    {
        return $this
            ->markdown('admin.mail.reports.total')
            ->subject('Сгенерирован отчёт: Итого')
            ->attach($this->csv)
        ;
    }
}
