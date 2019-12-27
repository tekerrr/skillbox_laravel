<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Service\Report\Report;

class SavedReportController extends Controller
{
    public function index(Report $report)
    {
        return view('admin.reports.saved-report', ['files' => $report->getAll()]);
    }

    public function download(Report $report, $file)
    {
        return $report->download($file) ?? abort(404);
    }

    public function destroyAll(Report $report)
    {
        $report->deleteAll();

        flash('Все отчёты удалены!');
        return back();
    }
}
