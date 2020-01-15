<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $news = \Cache::tags(['news', 'tags'])
            ->remember('news_tag|' . $tag->name, $this->getCacheTtl(), function () use ($tag) {
                return $tag->news()->active()->with('tags')->latest()->get();
            });

        $posts = \Cache::tags(['posts', 'tags'])
            ->remember('posts_tag|' . $tag->name, $this->getCacheTtl(), function () use ($tag) {
                return $tag->posts()->active()->with('tags')->latest()->get();
            });

        return view('tags.show', compact('news', 'posts'));
    }
}
