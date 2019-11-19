<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return view('admin.posts', compact('posts'));
    }

    public function activate(Post $post)
    {
        $post->update(['is_active' => true]);

        return back();
    }

    public function deactivate(Post $post)
    {
        $post->update(['is_active' => false]);

        return back();
    }
}
