<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $news = $tag->news()->active()->with('tags')->latest()->get();
        $posts = $tag->posts()->active()->with('tags')->latest()->get();

        return view('tags.show', compact('news', 'posts'));
    }
}
