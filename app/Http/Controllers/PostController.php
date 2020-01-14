<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Post;
use App\Tag;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:update,post')->only(['edit', 'update']);
        $this->middleware('can:delete,post')->only('destroy');
    }

    public function index()
    {
        $posts = \Cache::tags(['posts', 'tags'])->remember('posts|' . page(), $this->getCacheTtl(), function () {
            return Post::active()->latest()->with('tags')->simplePaginate(10);
        });

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $attributes = $request->validated();
        $attributes['is_active'] = $request->has('is_active');
        $attributes['owner_id'] = auth()->id();

        $post = Post::create($attributes);
        Tag::sync($post, $request->getTags());

        flash('Статья успешно создана');

        return redirect()->route('posts.index');
    }

    public function show($post)
    {
        $post = \Cache::tags(['posts', 'tags', 'comments|' . $post, 'post|' . $post])
            ->remember('post|' . $post, $this->getCacheTtl(), function () use ($post) {
                return Post::getBinding($post)->load('tags', 'comments.user', 'history');
            });

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post, UpdatePost $request)
    {
        $attributes = $request->validated();
        $attributes['is_active'] = $request->has('is_active');

        $post->update($attributes);
        Tag::sync($post, $request->getTags());

        flash('Статья успешно отредактирована');

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        flash('Статья удалена', 'danger');

        return redirect()->route('posts.index');
    }

    public function addComment(Post $post)
    {
        $attributes = $this->validate(request(), ['body' => 'required']);
        $attributes['owner_id'] = auth()->id();

        $post->comments()->create($attributes);

        return back();
    }
}
