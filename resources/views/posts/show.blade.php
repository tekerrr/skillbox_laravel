@extends('layout.master')

@section('title', $post->title)
@section('content_title')
    {{ $post->title }}
    @can('update', $post)
        @admin
            <a href="/admin/posts/">Редактировать</a>
        @else
            <a href="/posts/{{ $post->slug }}/edit">Редактировать</a>
        @endadmin
    @endcan
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
