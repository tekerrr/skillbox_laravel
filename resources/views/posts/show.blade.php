@extends('layout.master')

@section('title', $post->title)
@section('content_title')
    {{ $post->title }}
    @can('update', $post)
        @admin
            <a href="{{ route('admin.posts.index') }}">Редактировать</a>
        @else
            <a href="{{ route('posts.edit', compact('post')) }}">Редактировать</a>
        @endadmin
    @endcan
@endsection

@section('content')
    <div class="blog-post">
        @include('tags.items', ['tags' => $post->tags])

        <p class="blog-post-meta">{{ $post->created_at->toformattedDateString() }}</p>
        {{ $post->body }}

        @include('comment.index', ['comments' => $post->comments, 'parent' => $post])

        @include('history.index', ['history' => $post->history])

        <hr>
        <a href="{{ route('posts.index') }}">Вернуться к списку статей</a>
    </div>
@endsection
