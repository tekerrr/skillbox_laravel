<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        $attributes = $this->validate(request(), [
            'slug' => [
                'required' ,
                'regex:/^[\w\-]+$/',
                'unique:' . (new News())->getTable() . ',slug'
            ],
            'title' => 'required|min:5|max:100',
            'abstract' => 'required|max:255',
            'body' => 'required',
        ]);

        $attributes['is_active'] = request()->has('is_active');

        $news = News::create($attributes);

        // TODO add Tags

        flash('Новость успешно создана');

        return redirect('/admin/news');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $attributes = request()->validate([
            'slug'     => [
                'required',
                'regex:/^[\w\-]+$/',
                Rule::unique($news->getTable(), 'slug')->ignore($news->slug, 'slug'),
            ],
            'title'    => 'required|min:5|max:100',
            'abstract' => 'required|max:255',
            'body'     => 'required',
        ]);

        $attributes['is_active'] = request()->has('is_active');
        $news->update($attributes);

        // TODO add Tags

        flash('Новость успешно отредактирована');

        return redirect('/admin/news');
    }

    public function destroy(News $news)
    {
        $news->delete();

        flash('Новость удалена', 'danger');

        return redirect('/admin/news');
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
