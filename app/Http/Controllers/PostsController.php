<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::published()->latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('/posts.create');
    }

    public function store()
    {
        request()->validate([
            'slug' => [
                'required' ,
                'regex:/^[\w\-]+$/',
                'unique:' . (new Post())->getTable() . ',slug'
            ],
            'title' => 'required|min:5|max:100',
            'abstract' => 'required|max:255',
            'body' => 'required',
        ]);

        Post::create(request()->all());

        return redirect('/');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post)
    {
        request()->validate([
            'slug' => [
                'required' ,
                'regex:/^[\w\-]+$/',
                Rule::unique($post->getTable(), 'slug')->ignore($post->slug, 'slug'),
            ],
            'title' => 'required|min:5|max:100',
            'abstract' => 'required|max:255',
            'body' => 'required',
        ]);

        $attributes = request()->all();
        $attributes['published'] = (bool) request()->get('published');
        $post->update($attributes);

        return redirect('/posts');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts');
    }
}