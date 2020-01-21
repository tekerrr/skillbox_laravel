<?php

namespace App\Http\Controllers;

use App\News;
use App\Service\TaggedCache;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('addComment');
    }

    public function index()
    {
        $news = TaggedCache::news()
            ->with(TaggedCache::tags())
            ->remember('a_news|' . page(), function () {
                return News::active()->latest()->with('tags')->simplePaginate(5);
            });

        return view('news.index', compact('news'));
    }

    public function show($slug)
    {
        $news = TaggedCache::aNews($slug)
            ->with(TaggedCache::tags())
            ->with(TaggedCache::users())
            ->remember('a_news|' . $slug, function () use ($slug) {
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
