<?php

namespace App\Http\Controllers;

use App\Post;

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
        $this->validate(request(), [
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
}
