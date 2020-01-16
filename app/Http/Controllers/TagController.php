<?php

namespace App\Http\Controllers;

use App\Service\TaggedCache;
use App\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $news = TaggedCache::news()->remember('news_tag|' . $tag->name, function () use ($tag) {
            return $tag->news()->active()->with('tags')->latest()->get();
        });

        $posts = TaggedCache::posts()->remember('posts_tag|' . $tag->name, function () use ($tag) {
            return $tag->posts()->active()->with('tags')->latest()->get();
        });

        return view('tags.show', compact('news', 'posts'));
    }
}
