@extends('layout.master')

@section('title', $post->title)
@section('content_title')
    {{ $post->title }}
    <a href="/posts/{{ $post->slug }}/edit">Редактировать</a>
@endsection

@section('content')
    <div class="blog-post">
        @include('tags.items', ['tags' => $post->tags])

        <p class="blog-post-meta">{{ $post->created_at->toformattedDateString() }}</p>
        {{ $post->body }}

        <hr>
        <a href="/">Вернуться к списку статей</a>
    </div>
@endsection
