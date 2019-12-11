<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNews;
use App\Http\Requests\UpdateNews;
use App\News;
use App\Tag;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(StoreNews $request)
    {
        $attributes = $request->validated();
        $attributes['is_active'] = $request->has('is_active');

        $news = News::create($attributes);
        Tag::sync($news, $request->getTags());

        flash('Новость успешно создана');

        return redirect()->route('admin.news.index');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(UpdateNews $request, News $news)
    {
        $attributes = $request->validated();
        $attributes['is_active'] = $request->has('is_active');

        $news->update($attributes);
        Tag::sync($news, $request->getTags());

        flash('Новость успешно отредактирована');

        return redirect()->route('admin.news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();

        flash('Новость удалена', 'danger');

        return redirect()->route('admin.news.index');
    }

    public function activate(News $news)
    {
        $news->activate();

        return back();
    }

    public function deactivate(News $news)
    {
        $news->deactivate();

        return back();
    }
}
