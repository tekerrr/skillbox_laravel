<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SavedReportController extends Controller
{
    public function index()
    {
        $files = \Storage::files(config('admin.path.reports'));
        $files = collect($files)->map(function ($file) {
            return short_path($file);
        });
        return view('admin.reports.saved-report', compact('files'));
    }

    public function download($file)
    {
        return \Storage::download(config('admin.path.reports') . $file);
    }
}
