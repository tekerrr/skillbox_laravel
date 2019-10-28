@extends('layout.master')

@section('title', $post->title)

@section('content')
    <p class="blog-post-meta">{{ $post->created_at->toformattedDateString() }}</p>
    {{ $post->body }}

    <hr>

    <a href="/">Вернуться к списку статей</a>
@endsection
