<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        $posts = $tag->posts()->active()->with('tags')->latest()->get();

        return view('posts.index', compact('posts'));
    }
}
