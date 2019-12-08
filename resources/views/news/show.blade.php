@extends('layout.master')

@section('title', $news->title)
@section('content_title')
    {{ $news->title }}
    @admin
        <a href="{{ route('admin.news.edit', compact('news')) }}">Редактировать</a>
    @endadmin
@endsection

@section('content')
    <div class="blog-post">
        @include('tags.items', ['tags' => $news->tags])

        <p class="blog-post-meta">{{ $news->created_at->toformattedDateString() }}</p>
        {{ $news->body }}

        @include('comment.index', ['comments' => $news->comments, 'parentType' => 'news', 'parentId' => $news->id])

        <hr>
        <a href="{{ route('news.index') }}">Вернуться к списку новостей</a>

    </div>
@endsection
