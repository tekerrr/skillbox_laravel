<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\News;
use App\Post;
use App\User;

class StatisticsController extends Controller
{
    public function index()
    {
        $statistics['Общее количество статей'] = Post::count();
        $statistics['Общее количество новостей'] = News::count();
        $statistics['ФИО автора, у которого больше всего статей на сайте'] = Post::selectRaw('owner_id, COUNT(*) as posts_count')
            ->groupBy('owner_id')->orderByDesc('posts_count')->first()->user->name;

        $longestPost = Post::selectRaw('title, slug,  CHAR_LENGTH(body) as body_length')->orderByDesc('body_length')->first();
        $shortestPost = Post::selectRaw('title, slug,  CHAR_LENGTH(body) as body_length')->orderBy('body_length')->first();
        $statistics['Самая длинная статья'] = anchor(route('posts.show', ['post' => $longestPost]), $longestPost->title)
            . ' ' . $longestPost->body_length . ' символов';
        $statistics['Самая короткая  статья'] = anchor(route('posts.show', ['post' => $shortestPost]), $shortestPost->title)
            . ' ' . $shortestPost->body_length . ' символов';


        return view('admin.statistics', compact('statistics'));
    }
}
