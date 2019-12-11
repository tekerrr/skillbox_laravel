<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function index()
    {
        return view('admin.statistics', ['data' => (new \App\Service\Statistics())->get()]);
    }
}
