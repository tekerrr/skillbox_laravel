<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TotalController extends Controller
{
    public function index()
    {
        return view('admin.reports.total');
    }

    public function store()
    {
        if (! ($attributes = request()->except('_token'))) {
            flash('Не выбрано ни одного параметра.', 'danger');
            return back();
        }

        \App\Jobs\TotalReport::dispatch(array_keys($attributes), auth()->user());

        flash('Сгенерированный отчет будет выслан на почту.');
        return back();
    }
}
