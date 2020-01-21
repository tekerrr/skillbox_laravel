<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\TaggedCache;

class StatisticsController extends Controller
{
    public function index()
    {
        $data = TaggedCache::posts()
            ->with(TaggedCache::news())
            ->with(TaggedCache::comments())
            ->with(TaggedCache::users())
            ->remember('admin.statistics', function () {
                return (new \App\Service\Statistics())->get();
            });

        return view('admin.statistics', compact('data'));
    }
}
