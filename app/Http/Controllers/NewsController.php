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
        $news = \Cache::tags(['news', 'tags'])->remember('a_news|' . page(), $this->getCacheTtl(), function () {
            return News::active()->latest()->with('tags')->simplePaginate(5);
        });

        return view('news.index', compact('news'));
    }

    public function show($slug)
    {
        $cache = \Cache::tags([
            'a_news|' . $slug,
            'tags',
            'users',
        ]);

        $news = $cache->remember('a_news|' . $slug, $this->getCacheTtl(), function () use ($slug) {
            return News::getBindingModel($slug)->load('tags', 'comments.user');
        });

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
