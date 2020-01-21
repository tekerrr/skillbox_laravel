<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Service\TaggedCache;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = TaggedCache::posts()->remember('admin.posts', function () {
            return Post::latest()->get();
        });

        return view('admin.posts', compact('posts'));
    }

    public function activate(Post $post)
    {
        $post->activate();

        return back();
    }

    public function deactivate(Post $post)
    {
        $post->deactivate();

        return back();
    }
}
