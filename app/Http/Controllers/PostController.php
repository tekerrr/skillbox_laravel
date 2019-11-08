<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
        $this->middleware('can:update,post')->only(['edit', 'update']);
        $this->middleware('can:delete,post')->only('destroy');
    }

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
        $attributes = $this->validate(request(), [
            'slug' => [
                'required' ,
                'regex:/^[\w\-]+$/',
                'unique:' . (new Post())->getTable() . ',slug'
            ],
            'title' => 'required|min:5|max:100',
            'abstract' => 'required|max:255',
            'body' => 'required',
        ]);

        $attributes['published'] = request()->has('published');
        $attributes['owner_id'] = auth()->id();

        $post = Post::create($attributes);

        $newTags = collect(explode(', ', request('tags')))->keyBy(function ($item) { return $item; });

        foreach ($newTags as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $post->tags()->attach($tag);
        }

        flash('Статья успешно создана');

        return redirect('/posts');
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
        $attributes = request()->validate([
            'slug'     => [
                'required',
                'regex:/^[\w\-]+$/',
                Rule::unique($post->getTable(), 'slug')->ignore($post->slug, 'slug'),
            ],
            'title'    => 'required|min:5|max:100',
            'abstract' => 'required|max:255',
            'body'     => 'required',
        ]);

        $attributes['published'] = request()->has('published');
        $post->update($attributes);

        /** @var Collection $currentTags */
        $currentTags = $post->tags->keyBy('name');
        $newTags = collect(explode(', ', request('tags')))->keyBy(function ($item) { return $item; });

        $tagsToAttach = $newTags->diffKeys($currentTags);
        $tagsToDetach = $currentTags->diffKeys($newTags);

        foreach ($tagsToAttach as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $post->tags()->attach($tag);
        }

        foreach ($tagsToDetach as $tag) {
            $post->tags()->detach($tag);
        }

        flash('Статья успешно отредактирована');

        return redirect('/posts');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        flash('Статья удалена', 'danger');

        return redirect('/posts');
    }
}
