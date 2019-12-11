<?php


namespace App\Service;


use App\News;
use App\Post;

class Statistics
{
    private $data = [];

    public function __construct()
    {
        $this->data = collect();
    }

    public function get()
    {
        if (! app()->environment('testing')) {
            $this->run();
        }


        return $this->data;
    }

    private function run()
    {
        foreach (get_class_methods($this) as $method) {
            if (strpos($method, 'check') === 0) {
                $this->data = $this->data->merge($this->$method());
            }
        }
    }

    private function checkPosts()
    {
        $averageNumberFromActiveAuthors = Post::selectRaw('count(*) as posts_count')
            ->having('posts_count', '>', '1')
            ->groupBy('owner_id')
            ->pluck('posts_count')
            ->avg()
        ;

        return ['posts' => [
            'number' => Post::count(),
            'averageNumberFromActiveAuthors' => number_format($averageNumberFromActiveAuthors, 2),
        ]];
    }

    private function checkNews()
    {
        return ['news' => ['number' => News::count()]];
    }

    private function checkActivePosts()
    {
        return ['activePosts' => ['number' => Post::active()->count()]];
    }

    private function checkActiveNews()
    {
        return ['activeNews' => ['number' => News::active()->count()]];
    }

    private function checkMostProductiveAuthor()
    {
        $author = Post::selectRaw('owner_id, COUNT(*) as posts_count')
            ->groupBy('owner_id')
            ->orderByDesc('posts_count')
            ->first()
            ->user
        ;

        return ['mostProductiveAuthor' => ['name' => $author->name]];
    }

    private function checkLongestPost()
    {
        $post = Post::selectRaw('title, slug,  CHAR_LENGTH(body) as body_length')
            ->orderByDesc('body_length')
            ->first()
        ;

        return ['longestPost' => [
            'href' => route('posts.show', compact('post')),
            'title' => $post->title,
            'length' => $post->body_length,
        ]];
    }

    private function checkShortestPost()
    {
        $post = Post::selectRaw('title, slug,  CHAR_LENGTH(body) as body_length')
            ->orderBy('body_length')
            ->first()
        ;

        return ['shortestPost' => [
            'href' => route('posts.show', compact('post')),
            'title' => $post->title,
            'length' => $post->body_length,
        ]];
    }

    private function checkMostChangedPost()
    {
        $post = Post::select('title', 'slug')
            ->withCount('history')
            ->orderByDesc('history_count')
            ->first()
        ;

        return ['mostChangedPost' => [
            'href' => route('posts.show', compact('post')),
            'title' => $post->title,
            'times' => $post->history_count,
        ]];
    }

    private function checkMostCommentedPost()
    {
        $post = Post::select('title', 'slug')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->first()
        ;

        return ['mostCommentedPost' => [
            'href' => route('posts.show', compact('post')),
            'title' => $post->title,
            'times' => $post->comments_count,
        ]];
    }
}
