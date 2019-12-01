@extends('layout.master')

@section('title', $news->title)
@section('content_title')
    {{ $news->title }}
    @admin
        <a href="/admin/news/">Редактировать</a>
    @endadmin
@endsection

@section('content')
    <div class="blog-post">
        @include('tags.items', ['tags' => $news->tags])

        <p class="blog-post-meta">{{ $news->created_at->toformattedDateString() }}</p>
        {{ $news->body }}

        <hr>
        <a href="/">Вернуться к списку новостей</a>
    </div>
@endsection
