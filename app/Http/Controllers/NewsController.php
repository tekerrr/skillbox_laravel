<?php

namespace App\Http\Controllers;

use App\News;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('addComment');
    }

    public function index()
    {
        $news = News::active()->latest()->simplePaginate(5);

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function addComment(News $news)
    {
        $attributes = $this->validate(request(), ['body' => 'required']);
        $attributes['owner_id'] = auth()->id();

        $news->comments()->create($attributes);

        return back();
    }
}
